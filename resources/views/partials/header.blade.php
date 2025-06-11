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
                        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
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

        <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div x-show="menuOpen" x-transition class="md:hidden bg-[#414833] px-6 py-4">
        <ul class="flex flex-col space-y-4">
            <li><a href="{{ route('best-sellers') }}" class="hover:text-gray-300">Best Sellers</a></li>
            <li><a href="{{ route('about') }}" class="hover:text-gray-300">About</a></li>
            <li><a href="{{ route('shop') }}" class="hover:text-gray-300">Shop</a></li>
            <li><a href="{{ route('gifts') }}" class="hover:text-gray-300">Gifts</a></li>
        </ul>
        <div class="flex mt-4 space-x-4 text-xl">
            <a href="{{ route('profile') }}"><i class="fas fa-user"></i></a>
            <button @click="searchOpen = !searchOpen"><i class="fas fa-search"></i></button>
            <a href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>

    <div x-show="searchOpen" x-transition class="absolute top-full left-0 w-full bg-white text-black flex items-center px-6 py-2 z-30">
        <i class="fas fa-search mr-3"></i>
        <input type="text" placeholder="Search..." class="w-full bg-transparent outline-none">
        <button @click="searchOpen = false" class="ml-4 text-xl"><i class="fas fa-times"></i></button>
    </div>
</header>
