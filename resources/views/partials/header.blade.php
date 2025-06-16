<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<header x-data="{ menuOpen: false, searchOpen: false, profileOpen: false }" class="bg-[#414833] text-white py-2 relative">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/Scentscape.png') }}" alt="Scentscape Logo" class="h-10 w-auto">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex flex-1 ml-10 justify-between items-center">
            <ul class="flex space-x-6">
                <li><a href="{{ route('best-sellers') }}" class="hover:text-gray-300">Best Sellers</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-gray-300">About</a></li>
                <li><a href="{{ route('shop') }}" class="hover:text-gray-300">Shop</a></li>
                <li><a href="{{ route('gifts') }}" class="hover:text-gray-300">Gifts</a></li>
            </ul>
            <div class="flex items-center space-x-4 ml-6">
                <div x-data="{ open: false }" class="relative">
                    <!-- Avatar/Profile Icon -->
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('/images/profile.png') }}"
                             alt="Profile"
                             class="w-8 h-8 rounded-full border border-gray-300 object-cover">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" x-transition
                         class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-40"
                         @click.outside="open = false" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                <button @click="searchOpen = !searchOpen"><i class="fas fa-search text-lg"></i></button>
                <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart text-lg"></i></a>
            </div>
        </nav>

        <!-- Hamburger menu button -->
        <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="menuOpen" x-transition class="md:hidden bg-[#414833] px-6 py-4">
        <ul class="flex flex-col space-y-4">
            <li><a href="{{ route('best-sellers') }}" class="hover:text-gray-300">Best Sellers</a></li>
            <li><a href="{{ route('about') }}" class="hover:text-gray-300">About</a></li>
            <li><a href="{{ route('shop') }}" class="hover:text-gray-300">Shop</a></li>
            <li><a href="{{ route('gifts') }}" class="hover:text-gray-300">Gifts</a></li>
        </ul>

        <!-- Mobile Profile Dropdown -->
        <div class="flex mt-4 space-x-4 text-xl items-center">
            <div x-data="{ openMobileProfile: false }" class="relative">
                <button @click="openMobileProfile = !openMobileProfile" class="focus:outline-none">
                    <i class="fas fa-user text-white"></i>
                </button>
                <div
                    x-show="openMobileProfile"
                    x-transition
                    @click.outside="openMobileProfile = false"
                    class="absolute mt-2 bg-white text-sm text-gray-800 rounded-md shadow-lg py-2 w-32 z-50"
                >
                    <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <form id="logoutFormMobile" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="button" onclick="confirmLogoutMobile()" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-black">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <button @click="searchOpen = !searchOpen"><i class="fas fa-search text-white"></i></button>
            <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart text-white"></i></a>
        </div>
    </div>

    <!-- Search Bar -->
<form action="{{ route('shop') }}" method="GET"
      x-show="searchOpen" x-transition
      class="absolute top-full left-0 w-full bg-white text-black flex items-center px-6 py-2 z-30">
    <i class="fas fa-search mr-3"></i>
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari parfum..." class="w-full bg-transparent outline-none">
    <button type="submit" class="ml-4 text-sm text-black-600 hover:underline">Cari</button>
    <button type="button" @click="searchOpen = false" class="ml-2 text-xl">
        <i class="fas fa-times"></i>
    </button>
</form>

</header>

<!-- SweetAlert Logout Confirmation -->
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Anda yakin ingin keluar dari akun?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Merah
            cancelButtonColor: '#d1d5db',  // Abu-abu lembut
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }

    function confirmLogoutMobile() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Anda yakin ingin keluar dari akun?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Merah
            cancelButtonColor: '#d1d5db',  // Abu-abu lembut
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutFormMobile').submit();
            }
        });
    }
</script>
