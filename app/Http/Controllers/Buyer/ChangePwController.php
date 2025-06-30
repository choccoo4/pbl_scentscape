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
        return view('buyer.change_pw');
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
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.confirmed' => 'Password confirmation does not match.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.letters' => 'New password must contain letters.',
            'new_password.mixed_case' => 'New password must contain both uppercase and lowercase letters.',
            'new_password.numbers' => 'New password must include numbers.',
            'new_password.symbols' => 'New password must contain at least one symbol.',
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ])->withInput();
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'The new password must be different from the current password.'
            ])->withInput();
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
                // Jika kolom waktu_perubahan bermasalah, hapus baris berikut
                'waktu_perubahan' => Carbon::now(),
            ]);

            Auth::logout();

            return redirect()->route('login')->with('success', 'Password changed successfully. Please log in again.');
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'An error occurred while updating your password. Please try again.'
            ])->withInput();
        }
    }
}
