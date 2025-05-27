<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        session(['user_id' => $pengguna->id, 'role' => $pengguna->role]);

        return response()->json(['message' => 'Login berhasil', 'role' => $pengguna->role]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        try {
            // Validasi input secara manual agar bisa kasih respon lebih detail
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:pengguna,Email',
                'name' => 'required|string',
                'username' => 'required|string|unique:pengguna,Username',
                'password' => 'required|string|min:8',
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
