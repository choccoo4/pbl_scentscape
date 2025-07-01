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
        // Validate input
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
            'new_password.numbers' => 'New password must contain numbers.',
            'new_password.symbols' => 'New password must contain symbols.',
        ]);

        // Refresh user data from the database to ensure the latest data
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $user = $user->fresh();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password does not match.'
            ])->withInput();
        }

        // Check if the new password is the same as the current one
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'New password must not be the same as the current password.'
            ])->withInput();
        }

        try {
            // Use transaction to ensure data consistency
            DB::transaction(function () use ($user, $request) {
                // Update password and updated time
                // If the model has a mutator, the password will be hashed automatically
                // If not, use manual Hash::make()
                $user->update([
                    'password' => Hash::make($request->new_password),
                    'waktu_perubahan' => Carbon::now()
                ]);

                // Force refresh model from the database
                $user->refresh();
            });

            // Verify the new password was saved correctly
            $updatedUser = $user->fresh();
            if (!Hash::check($request->new_password, $updatedUser->password)) {
                throw new \Exception('Password verification failed after update');
            }

            // Invalidate all sessions related to authentication
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Explicitly logout the user
            Auth::logout();

            // Redirect to login page with success message
            return redirect()->route('login')->with('success', 'Password changed successfully! Please log in again.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while updating the password. Please try again.'
            ])->withInput();
        }
    }
}
