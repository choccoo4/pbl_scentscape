@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] flex  md:flex-row">
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
                <a href="#">Order History</a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
<main class="flex-1 p-6 flex justify-center items-start">
    <div class="bg-white p-6 shadow-md w-full md:w-3/4">
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Order History</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">No. Pesanan</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Jumlah Total</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="p-2 border">143999</td>
                        <td class="p-2 border">12/08/2025</td>
                        <td class="p-2 border">Rp 774.000</td>
                        <td class="p-2 border">Terkirim</td>
                        <td class="p-2 border text-blue-600 underline"><a href="#">Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
</div>
@endsection
