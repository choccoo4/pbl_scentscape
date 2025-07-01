@extends('layouts.seller')
@section('title', 'Change Password')

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
                        <span>My Account</span>
                    </div>
                    <ul class="pl-6 mt-2 space-y-1 text-sm transition-all duration-300 group-hover:max-h-32 max-h-0 overflow-hidden">
                        <li><a href="{{ route('profil-penjual') }}" class="hover:text-[#BFA6A0]">Profile</a></li>
                        <li><a href="{{ route('ubahpw') }}" class="hover:text-[#BFA6A0]">Change Password</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-semibold mb-6 border-b pb-2">Change Password</h2>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('ubahpw.update') }}" class="space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block font-medium mb-1">Current Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" id="current_password" name="current_password"
                            placeholder="Enter current password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10 @error('current_password') border-red-500 @enderror">
                        <button type="button" @click="showCurrent = !showCurrent"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i :class="showCurrent ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                        </button>
                    </div>
                    @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block font-medium mb-1">New Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'" id="new_password" name="new_password"
                            placeholder="Enter new password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10 @error('new_password') border-red-500 @enderror">
                        <button type="button" @click="showNew = !showNew"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i :class="showNew ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        Password must be at least 8 characters and include uppercase, lowercase, number, and symbol.
                    </p>
                    @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block font-medium mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" id="new_password_confirmation" name="new_password_confirmation"
                            placeholder="Confirm new password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10 @error('new_password_confirmation') border-red-500 @enderror">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i :class="showConfirm ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                        </button>
                    </div>
                    @error('new_password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit"
                        class="bg-[#9BAF9A] text-white px-6 py-2 rounded hover:bg-[#88a28a] transition-all">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                    <a href="{{ route('profil-penjual') }}"
                        class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
    // Optional: Real-time password strength indicator
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const requirements = [
            { regex: /.{8,}/, text: 'At least 8 characters' },
            { regex: /[a-z]/, text: 'Lowercase letter' },
            { regex: /[A-Z]/, text: 'Uppercase letter' },
            { regex: /\d/, text: 'Number' },
            { regex: /[^A-Za-z0-9]/, text: 'Symbol' }
        ];

        // You can add password strength indicator here if needed
    });
</script>
@endsection
