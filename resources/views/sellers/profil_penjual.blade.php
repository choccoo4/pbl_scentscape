@extends('layouts.seller')

@section('title', 'My Profile')

@section('content')

<div class="bg-[#FDF6EF] min-h-screen py-12"
    data-has-profile-pic="{{ asset('storage/' . $penjual->pengguna->foto_profil) !== asset('storage/') ? '1' : '' }}"
    data-success-message="{{ session('success') }}">
    <div class="flex max-w-6xl mx-auto gap-6">
        <aside class="w-[180px] shrink-0 bg-[#FDF6EF] p-6">
            <div class="flex items-center gap-4 mb-6 px-2">
                <img src="{{ $penjual->pengguna->foto_profil ? asset('storage/' . $penjual->pengguna->foto_profil) : '/images/profile.png' }}" class="w-10 h-10 rounded-full" alt="Profile Icon">
                <p class="font-semibold text-sm">{{ $penjual->pengguna->nama ?? Auth::user()->nama ?? 'Admin' }}</p>
            </div>

            <ul class="space-y-2 text-left font-medium ml-4 group">
                <li class="relative">
                    <div class="flex items-center space-x-2 hover:text-[#9BAF9A] transition-all cursor-pointer group-hover:text-[#9BAF9A]">
                        <i class="fas fa-user"></i>
                        <span>Akun Saya</span>
                    </div>
                    <ul class="pl-6 mt-2 space-y-1 text-sm transition-all duration-300 group-hover:max-h-32 max-h-0 overflow-hidden">
                        <li><a href="{{ route('profil-penjual') }}" class="hover:text-[#BFA6A0]">Profil</a></li>
                        <li><a href="{{ route('ubahpw') }}" class="hover:text-[#BFA6A0]">Ubah Kata Sandi</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Profile Content -->
        <section class="flex-1 bg-white p-10 rounded-lg shadow-md mx-6">
            <!-- Greeting -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-[#3E3A39]">Selamat Datang Kembali, <span class="text-[#9BAF9A]">
                        {{ $penjual->pengguna->nama ?? 'Admin' }}</span>!
                </h2>
                <p class="text-sm text-gray-500">Perbarui profil Anda untuk menjaga semuanya tetap terkini✨</p>
            </div>

            <!-- Form Update Profil -->
            <form action="{{ route('profil-penjual.update') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="text-center mb-8">
                    <img id="profilePicPreview"
                        src="{{ $penjual->pengguna->foto_profil ? asset('storage/' . $penjual->pengguna->foto_profil) : asset('/images/profile.png') }}"
                        class="w-24 h-24 rounded-full border-4 border-[#D6C6B8] mx-auto mb-2 shadow-md"
                        alt="Profil Penjual">

                    <label for="profilePicInput" class="text-sm text-[#9BAF9A] hover:underline cursor-pointer">
                        ✎ Ubah Foto Profil
                    </label>
                    <input id="profilePicInput" type="file" name="foto_profil" class="hidden" accept="image/*"
                        {{ !$penjual->pengguna->foto_profil ? 'required' : '' }}>
                </div>

                <!-- Nama Toko -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium text-[#3E3A39]" for="nama_toko">Nama Toko</label>
                    <input
                        type="text"
                        name="nama_toko"
                        id="nama_toko"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                        value="{{ old('nama_toko', $penjual->pengguna->nama ?? Auth::user()->nama) }}"
                        placeholder="Nama Toko Anda"
                        required>
                </div>

                <!-- Deskripsi Toko -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium text-[#3E3A39]" for="deskripsi_toko">Deskripsi Toko</label>
                    <textarea
                        name="deskripsi_toko"
                        id="deskripsi_toko"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9BAF9A]"
                        rows="4"
                        placeholder="Deskripsi Toko Anda"
                        required>{{ old('deskripsi_toko', $penjual->deskripsi_toko ?? '') }}</textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="text-right">
                    @if ($errors->any())
                    <div class="mb-4 text-red-500 bg-red-100 border border-red-300 rounded p-3">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <button type="submit" class="bg-[#9BAF9A] text-white px-6 py-2 rounded-lg hover:bg-[#889d87] transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <hr class="my-8 border-[#E5DAD2]">

            <!-- Extra Info Section -->
            <div class="text-sm text-gray-500 italic">
                <p>📅 Last updated: <span class="text-[#BFA6A0]">
                        {{ $penjual->pengguna->waktu_perubahan ? $penjual->pengguna->waktu_perubahan->format('d F Y H:i:s') : '-' }}
                    </span></p>
                <p class="mt-1">💡 Tip: Keeping your info up-to-date helps with smooth checkout and delivery!</p>
            </div>
        </section>
    </div>
</div>

@endsection