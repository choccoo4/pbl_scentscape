<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        // Get seller data with user relation based on logged-in user
        $penjual = Penjual::where('id_pengguna', Auth::id())->with('pengguna')->first();

        if (!$penjual) {
            // If seller data does not exist, create new instance with default values
            $penjual = new Penjual();
            $penjual->id_pengguna = Auth::id();
            $penjual->deskripsi_toko = 'Your store description';

            // Set user relation to prevent view error
            $penjual->setRelation('pengguna', Auth::user());
        }

        return view('sellers.profil_penjual', compact('penjual'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $penjual = $user->penjual;

        // Determine profile photo validation rule, required if not already available
        $fotoRule = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        // Validate input
        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi_toko' => 'required|string',
            'foto_profil' => $fotoRule,
        ], [
            'foto_profil.required' => 'Profile photo is required.',
            'nama_toko.required' => 'Store name is required.',
            'deskripsi_toko.required' => 'Store description is required.',
        ]);

        // If seller does not exist, create a new one
        if (!$penjual) {
            $penjual = new Penjual();
            $penjual->id_pengguna = $user->id_pengguna;
        }

        // Update name and updated time in user
        $user->nama = $validatedData['nama_toko'];
        $user->waktu_perubahan = now();

        // Process profile photo upload if exists
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $file = $request->file('foto_profil');
            $filename = 'profile_penjual_' . $user->id_pengguna . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures/penjual', $filename, 'public');

            $user->foto_profil = $path;
        }

        // Save user changes
        $user->save();

        // Update store description in seller
        $penjual->deskripsi_toko = $validatedData['deskripsi_toko'];
        $penjual->save();

        // Synchronize profile photo to buyer if exists
        $pembeli = $user->pembeli;
        if ($pembeli) {
            $pembeliUser = $pembeli->pengguna;
            if ($pembeliUser) {
                $pembeliUser->foto_profil = $user->foto_profil;
                $pembeliUser->save();
            }
        }

        return redirect()->route('profil-penjual')->with('success', 'Profile updated successfully');
    }
}
