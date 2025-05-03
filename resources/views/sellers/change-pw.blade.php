@extends('layouts.seller')
@section('title', 'Change Password')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-4">
    <div class="flex max-w-6xl mx-auto gap-6">
        <!-- Sidebar -->
        <aside class="w-full md:w-1/5 bg-[#FDF6EF] p-6">
            <div class="flex items-center gap-4 mb-6 px-2">
                <img src="/images/profile.png" class="w-10 h-10 rounded-full" alt="Profile Icon">
                <p class="font-semibold text-lg">Admin</p>
            </div>
            <ul class="space-y-2 text-left font-medium ml-4 group">
                <li class="relative">
                    <div class="flex items-center space-x-2 hover:text-[#9BAF9A] transition-all cursor-pointer group-hover:text-[#9BAF9A]">
                        <i class="fas fa-user"></i>
                        <span>My Account</span>
                    </div>
                    <ul class="pl-6 mt-2 space-y-1 text-sm transition-all duration-300 group-hover:max-h-32 max-h-0 overflow-hidden">
                        <li><a href="{{ route('profil-penjual') }}" class="hover:text-[#BFA6A0]">Profile</a></li>
                        <li><a href="{{ route('Ubahpasswrod-penjual') }}" class="hover:text-[#BFA6A0]">Change Password</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-semibold mb-6 border-b pb-2">Change Password</h2>

            <form method="POST" action="#" class="space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block font-medium mb-1">Current Password</label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" id="current_password" name="current_password"
                            placeholder="Enter current password"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10">
                        <button type="button" @click="showCurrent = !showCurrent"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block font-medium mb-1">New Password</label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'" id="new_password" name="new_password"
                            placeholder="Enter new password"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10">
                        <button type="button" @click="showNew = !showNew"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block font-medium mb-1">Confirm New Password</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" id="new_password_confirmation" name="new_password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#9BAF9A] pr-10">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="bg-[#9BAF9A] text-white px-6 py-2 rounded hover:bg-[#88a28a] transition-all">
                        Save Changes
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection