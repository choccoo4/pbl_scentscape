@extends('layouts.app')
@section('title', 'Change Password')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-4">
    <div class="flex flex-col md:flex-row max-w-6xl mx-auto gap-6">
        <!-- Sidebar -->
        @include('components.sidebar-profile')

        <!-- Main Content -->
        <main class="w-full bg-white p-6 md:p-8 rounded shadow">
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

            <form method="POST" action="{{ route('change-pw.update') }}" class="space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
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
                            <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
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
                            <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a symbol
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
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('new_password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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