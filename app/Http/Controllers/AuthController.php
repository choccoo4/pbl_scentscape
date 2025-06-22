<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Password;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Email tidak terdaftar. Silakan daftar terlebih dahulu.'], 404);
        }

        if (!Hash::check($request->password, $pengguna->password)) {
            return response()->json(['message' => 'Password salah. Coba lagi.'], 401);
        }

        Auth::login($pengguna);
        session(['role' => $pengguna->role]);

        return response()->json(['message' => 'Login berhasil', 'role' => $pengguna->role]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'pembeli') {
                return redirect('/home');
            } elseif ($role === 'penjual') {
                return redirect('/dashboard');
            }
        }

        return view('auth.login');
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:pengguna,email',
                'name' => 'required|string',
                'username' => 'required|string|unique:pengguna,username',
                'password' => [
                    'required',
                    'string',
                    PasswordRule::min(8)->mixedCase()->letters()->numbers()->symbols(),
                ],
            ]);

            if ($validator->fails()) {
                if ($validator->errors()->has('email')) {
                    return response()->json([
                        'message' => 'Email sudah terdaftar. Silakan login.'
                    ], 409);
                }

                if ($validator->errors()->has('username')) {
                    return response()->json([
                        'message' => 'Username sudah digunakan. Coba yang lain.'
                    ], 409);
                }

                if ($validator->errors()->has('password')) {
                    return response()->json([
                        'message' => 'Password terlalu lemah. Gunakan huruf besar, kecil, angka, dan simbol.',
                        'field' => 'password'
                    ], 422);
                }

                return response()->json([
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            Pengguna::create([
                'email' => $request->email,
                'nama' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'pembeli',
                'waktu_pembuatan' => now(),
                'waktu_perubahan' => now(),
            ]);

            return response()->json([
                'message' => 'Registrasi berhasil'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'
            ], 500);
        }
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pengguna,email',
        ]);

        $status = Password::broker('pengguna')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }

    public function showResetForm($token, Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $status = Password::broker('pengguna')->reset(
            [
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            // Kembali ke halaman reset dengan pesan sukses agar bisa ditangkap di SweetAlert
            return redirect()->back()->with('reset_success', 'Password berhasil direset!');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
