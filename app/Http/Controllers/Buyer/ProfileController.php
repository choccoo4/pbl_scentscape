<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembeli;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function profile()
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $pembeli = Pembeli::with('pengguna')->where('id_pengguna', $user->id_pengguna)->first();

        if (!$pembeli) {
            $pembeli = new Pembeli();
            $pembeli->id_pengguna = $user->id_pengguna;
            $pembeli->alamat = '';
            $pembeli->no_telp = '';
            $pembeli->setRelation('pengguna', $user);
        }

        return view('buyer.profile', compact('pembeli'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pembeli = Pembeli::firstOrNew(['id_pengguna' => $user->id_pengguna]);
        $pembeli->alamat = $request->input('alamat');
        $pembeli->no_telp = $request->input('no_telp');
        $pembeli->save();

        $user->nama = $request->input('nama');

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $file = $request->file('foto_profil');
            $filename = 'profile_pembeli_' . $user->id_pengguna . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures/pembeli', $filename, 'public');

            $user->foto_profil = $path;
        }

        $user->waktu_perubahan = Carbon::now('Asia/Jakarta');
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
    }
}
