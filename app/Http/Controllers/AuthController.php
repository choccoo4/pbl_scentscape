<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pembeli;


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

        // Simpan ke session atau token
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
        $pengguna = new Pengguna();
        $pengguna->password = Hash::make($request->password);
        try {
            // Validasi input secara manual agar bisa kasih respon lebih detail
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:pengguna,Email',
                'name' => 'required|string',
                'username' => 'required|string|unique:pengguna,Username',
                'password' => [
                    'required',
                    'string',
                    PasswordRule::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                ],
            ]);

            if ($validator->fails()) {
                if ($validator->errors()->has('email')) {
                    return response()->json([
                        'message' => 'Email sudah terdaftar. Silakan login.'
                    ], 409); // 409 Conflict
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

            // Jika validasi lolos, buat pengguna
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
}
