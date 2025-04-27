<header x-data="{ menuOpen: false, searchOpen: false }" class="bg-teal-900 text-white py-4 relative">
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
                <a href="{{ route('profile') }}"><i class="fas fa-user text-lg"></i></a>
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

    <div x-show="menuOpen" x-transition class="md:hidden bg-teal-800 px-6 py-4">
        <ul class="flex flex-col space-y-4">
            <li><a href="{{ route('best-sellers') }}" class="hover:text-gray-300">Best Sellers</a></li>
            <li><a href="{{ route('about') }}" class="hover:text-gray-300">About</a></li>
            <li><a href="{{ route('shop') }}" class="hover:text-gray-300">Shop</a></li>
            <li><a href="{{ route('gifts') }}" class="hover:text-gray-300">Gifts</a></li>
        </ul>
        <div class="flex mt-4 space-x-4 text-xl">
            <a href="#"><i class="fas fa-user"></i></a>
            <button @click="searchOpen = !searchOpen"><i class="fas fa-search"></i></button>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>

    <div x-show="searchOpen" x-transition class="absolute top-full left-0 w-full bg-white text-black flex items-center px-6 py-3 z-50">
        <i class="fas fa-search mr-3"></i>
        <input type="text" placeholder="Search..." class="w-full bg-transparent outline-none">
        <button @click="searchOpen = false" class="ml-4 text-xl"><i class="fas fa-times"></i></button>
    </div>
</header>
