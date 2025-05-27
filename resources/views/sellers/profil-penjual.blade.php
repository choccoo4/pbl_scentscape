@extends('layouts.seller')

@section('title', 'My Profile')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-12">
    <div class="flex max-w-6xl mx-auto">
        <!-- Sidebar -->
        <aside class="w-1/4 md:w-1/5 bg-[#FDF6EF] p-6">
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
                        <li><a href="{{ route('ubahpw') }}" class="hover:text-[#BFA6A0]">Change Password</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Profile Content -->
        <section class="flex-1 bg-white p-10 rounded-lg shadow-md mx-6">
            <!-- Greeting -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-[#3E3A39]">Welcome back, <span class="text-[#9BAF9A]">Admin</span>!</h2>
                <p class="text-sm text-gray-500">Update your profile to keep everything up-to-date ✨</p>
            </div>

            <!-- Profile Picture -->
            <div class="text-center mb-8">
                <img src="/images/profile.png"
                    class="w-24 h-24 rounded-full border-4 border-[#D6C6B8] mx-auto mb-2 shadow-md"
                    alt="Profile Picture">

                <label for="profilePicInput" class="text-sm text-[#9BAF9A] hover:underline cursor-pointer">
                    ✎ Change profile picture
                </label>
                <input id="profilePicInput" type="file" class="hidden" accept="image/*">
            </div>

            <!-- Profile Form -->
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-user text-[#BFA6A0]"></i> Name
                    </label>
                    <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" placeholder="Your Name">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-phone text-[#BFA6A0]"></i> Phone Number
                    </label>
                    <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" placeholder="Your Phone Number">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-[#BFA6A0]"></i> Address
                    </label>
                    <textarea class="w-full border px-4 py-2 rounded bg-gray-100" rows="4" placeholder="Your Address"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-store text-[#BFA6A0]"></i> Deskripsi Toko
                    </label>
                    <textarea class="w-full border px-4 py-2 rounded bg-gray-100" rows="5" placeholder="Beritahu pelanggan tentang toko Anda..."></textarea>
                </div>


                <button class="bg-[#9BAF9A] text-white px-6 py-2 rounded hover:bg-[#8aa38a] transition-colors">
                    Save
                </button>
            </form>

            <!-- Divider -->
            <hr class="my-8 border-[#E5DAD2]">

            <!-- Extra Info Section -->
            <div class="text-sm text-gray-500 italic">
                <p>📅 Last updated: <span class="text-[#BFA6A0]">April 22, 2025</span></p>
                <p class="mt-1">💡 Tip: Keeping your info up-to-date helps with smooth checkout and delivery!</p>
            </div>
        </section>
    </div>
</div>
@endsection