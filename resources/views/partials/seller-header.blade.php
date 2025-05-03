<!-- Navbar -->
<div class="flex items-center justify-between bg-[#414833] px-6 py-2 shadow">
    <div class="flex items-center gap-4">
        <img src="{{ asset('images/Scentscape.png') }}" alt="Scentscape Logo" class="h-13 mx-auto">
    </div>
    <div class="w-1/2 relative bg-white rounded-lg">
        <input
            type="text"
            placeholder="Cari produk berdasarkan nama"
            class="w-full px-4 py-2 pr-10 rounded-lg text-sm focus:outline-none" />
        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
    </div>

    <div class="text-white flex items-center gap-4">
        <!-- Avatar/Profile Icon -->
        <button @mouseenter="open = true" @mouseleave.away="open = false" @click="open = !open"
            class="flex items-center space-x-2 focus:outline-none">
            <img src="/images/profile.png" alt="Profile" class="w-8 h-8 rounded-full border border-gray-300">
            <a href="{{ route('profil-penjual') }}" class="text-sm">Profile</a>
        </button>
        <form action="{{ route('logout') }}" method="POST" class="ml-2">
            @csrf
            <button type="submit" title="Logout">
                <i class="fa-solid fa-arrow-right-from-bracket text-white hover:text-red-500"></i>
            </button>
        </form>
    </div>

</div>