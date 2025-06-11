<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class ChangePwController extends Controller
{
    public function changePw()
    {
        return view('buyer.change-pw');
    }

    public function updatePassword(Request $request)
    {
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

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ])->withInput();
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'Password baru tidak boleh sama dengan password lama.'
            ])->withInput();
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
                // Jika kolom waktu_perubahan bermasalah, hapus baris berikut
                'waktu_perubahan' => Carbon::now(),
            ]);

            Auth::logout();

            return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login kembali.');

        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.'
            ])->withInput();
        }
    }
}
