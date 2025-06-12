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
        // Ambil data penjual dengan relasi pengguna berdasarkan user login
        $penjual = Penjual::where('id_pengguna', Auth::id())->with('pengguna')->first();

        if (!$penjual) {
            // Jika belum ada data penjual, buat instance baru dengan nilai default
            $penjual = new Penjual();
            $penjual->id_pengguna = Auth::id();
            $penjual->deskripsi_toko = 'Deskripsi toko Anda';

            // Set relasi pengguna agar view tidak error
            $penjual->setRelation('pengguna', Auth::user());
        }

        return view('sellers.profil-penjual', compact('penjual'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $penjual = $user->penjual;

        // Tentukan aturan validasi foto profil, wajib jika belum ada
        $fotoRule = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        // Validasi input
        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi_toko' => 'required|string',
            'foto_profil' => $fotoRule,
        ], [
            'foto_profil.required' => 'Foto profil wajib diisi.',
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'deskripsi_toko.required' => 'Deskripsi toko wajib diisi.',
        ]);

        // Jika penjual belum ada, buat baru
        if (!$penjual) {
            $penjual = new Penjual();
            $penjual->id_pengguna = $user->id_pengguna;
        }

        // Update nama dan waktu perubahan di user
        $user->nama = $validatedData['nama_toko'];
        $user->waktu_perubahan = now();

        // Proses upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $file = $request->file('foto_profil');
            $filename = 'profile_penjual_' . $user->id_pengguna . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures/penjual', $filename, 'public');

            $user->foto_profil = $path;
        }

        // Simpan perubahan user
        $user->save();

        // Update deskripsi toko di penjual
        $penjual->deskripsi_toko = $validatedData['deskripsi_toko'];
        $penjual->save();

        // Sinkronisasi foto profil ke pembeli jika ada
        $pembeli = $user->pembeli;
        if ($pembeli) {
            $pembeliUser = $pembeli->pengguna;
            if ($pembeliUser) {
                $pembeliUser->foto_profil = $user->foto_profil;
                $pembeliUser->save();
            }
        }

        return redirect()->route('profil-penjual')->with('success', 'Profil berhasil diperbarui');
    }
}
