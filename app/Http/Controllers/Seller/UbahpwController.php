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
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.confirmed' => 'Password confirmation does not match.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.letters' => 'New password must contain letters.',
            'new_password.mixed_case' => 'New password must contain both uppercase and lowercase letters.',
            'new_password.numbers' => 'New password must include numbers.',
            'new_password.symbols' => 'New password must contain at least one symbol.',
        ]);

        // Refresh user data dari database untuk memastikan data terbaru
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $user = $user->fresh();

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ])->withInput();
        }

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'The new password must be different from the current password.'
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

            // Verifikasi password baru tersimpan
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
            return redirect()->route('login')->with('success', 'Password changed successfully. Please log in again.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while updating your password. Please try again.'
            ])->withInput();
        }
    }
}
