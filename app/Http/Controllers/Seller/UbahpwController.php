<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\Penjual;
use Carbon\Carbon;

class UbahpwController extends Controller
{
    public function ubahpw()
    {
        $penjual = Penjual::where('id_pengguna', Auth::id())->with('pengguna')->first();

        return view('sellers.change_password', compact('penjual'));
    }

    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.letters' => 'Password baru harus mengandung huruf.',
            'new_password.mixed_case' => 'Password baru harus mengandung huruf besar dan kecil.',
            'new_password.numbers' => 'Password baru harus mengandung angka.',
            'new_password.symbols' => 'Password baru harus mengandung simbol.',
        ]);

        // Refresh user data dari database untuk memastikan data terbaru
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $user = $user->fresh();

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ])->withInput();
        }

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'Password baru tidak boleh sama dengan password lama.'
            ])->withInput();
        }

        try {
            // Gunakan transaction untuk memastikan konsistensi data
            DB::transaction(function () use ($user, $request) {
                // Update password dan waktu perubahan
                // Jika model punya mutator, password akan otomatis di-hash
                // Jika tidak, gunakan Hash::make() manual
                $user->update([
                    'password' => Hash::make($request->new_password), // Manual hash untuk safety
                    'waktu_perubahan' => Carbon::now()
                ]);

                // Force refresh model dari database
                $user->refresh();
            });

            // Verifikasi password baru berhasil tersimpan
            $updatedUser = $user->fresh();
            if (!Hash::check($request->new_password, $updatedUser->password)) {
                throw new \Exception('Password verification failed after update');
            }

            // Hapus semua session yang berkaitan dengan authentication
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Logout user secara eksplisit
            Auth::logout();

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login kembali.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.'
            ])->withInput();
        }
    }
}
