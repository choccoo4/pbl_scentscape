<!-- NAVBAR -->
<nav class="fixed top-0 z-50 w-full bg-[#414833]">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Kiri: Toggle & Logo -->
            <div class="flex items-center">
                <!-- Sidebar Toggle (Mobile) -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/Scentscape.png') }}" alt="Scentscape Logo" class="h-10">
                </a>
            </div>

            <!-- Kanan: User Menu -->
            <div class="flex items-center">
                <div class="relative">
                    <!-- User Profile Toggle -->
                    <button type="button" class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                        data-dropdown-toggle="dropdown-user" aria-expanded="false">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="/images/profile.png" alt="user photo">
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdown-user" class="hidden absolute right-0 mt-2 w-48 bg-[#f8f4e9] rounded shadow divide-y divide-[#d6c6b8] z-50">
                        <div class="px-4 py-3">
                            <p class="text-sm font-semibold text-[#414833]">Admin</p>
                            <p class="text-sm font-medium text-[#5a614f] truncate">Scentscape@gmail.com</p>
                        </div>
                        <ul class="py-1 text-sm text-[#414833]">
                            <li>
                                <a href="profil-penjual" class="block px-4 py-2 rounded hover:bg-[#d6c6b8] hover:text-[#414833] transition-colors">Profile</a>
                            </li>
                            <li>
                                <a href="changePassword" class="block px-4 py-2 rounded hover:bg-[#d6c6b8] hover:text-[#414833] transition-colors">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-50 min-h-full pt-20 transition-transform -translate-x-full sm:translate-x-0 bg-[#414833] border-r border-[#d6c6b8]"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-2 font-medium text-white">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-[#5a614f] transition-colors group">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <!-- Produk -->
            <li>
                <a href="{{ route('produk.index') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-[#5a614f] transition-colors group">
                    <i class="fa-solid fa-box" style="color: #ffffff;"></i>
                    <span class="ms-3">Produk</span>
                </a>
            </li>

            <li>
                <a href="{{ route('pesanan.index') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-[#5a614f] transition-colors group">
                    <i class="fa-solid fa-clipboard-list" style="color: #ffffff;"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Pesanan</span>
                    <span
                        class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">3</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rekap.index') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-[#5a614f] transition-colors group">
                    <i class="fa-solid fa-chart-line" style="color: #ffffff;"></i>
                    <span class="ms-3">Rekapitulasi Penjualan</span>
                </a>
            </li>
        </ul>
    </div>
</aside>