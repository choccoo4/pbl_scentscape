@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-12">
    <div class="flex max-w-6xl">
        <!-- Sidebar -->
        <aside class="w-full md:w-1/5 bg-[#FDF6EF] p-6 border-r-0 border-gray-300">
    <div class="flex items-center gap-4 mb-6 px-2">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="w-10 h-10" alt="Profile Icon">
    <p class="font-semibold text-lg">username</p>
</div>
        <ul class="space-y-4 text-left font-medium ml-8">
            <li class="flex items-center space-x-2">
                <i class="fas fa-user"></i>
                <a href="#">My Account</a>
            </li>
            <li class="ml-8"><a href="#">Profile</a></li>
            <li class="ml-8"><a href="#">Change Password</a></li>
            <li class="flex items-center space-x-2 font-medium text-black">
                <i class="fas fa-box"></i>
                <a href="{{ route('order.history') }}">Order History</a>
            </li>
        </ul>
    </aside>

        <!-- Profile Content -->
        <section class="flex-1 bg-white p-10 rounded-lg shadow-md mx-10">
            <h1 class="text-2xl font-semibold mb-6 border-b pb-2">My Profile</h1>

            <div class="text-center mb-8">
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="w-20 h-20 mx-auto mb-2" alt="Profile Picture">
                <p class="text-sm text-gray-500">✎ change profile-picture</p>
            </div>

            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" placeholder="Your Name">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Phone Number</label>
                    <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" placeholder="Your Phone Number">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Address</label>
                    <textarea class="w-full border px-4 py-2 rounded bg-gray-100" rows="4" placeholder="Your Address"></textarea>
                </div>
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Save</button>
            </form>
        </section>
    </div>
</div>
@endsection
