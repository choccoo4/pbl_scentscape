<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Header -->
<header x-data="{ menuOpen: false, searchOpen: false }" class="bg-teal-900 text-white py-4 relative">
    <div class="container mx-auto px-6 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('images/Scentscape.png') }}" alt="Scentscape Logo" class="h-10 w-auto">
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex flex-1 ml-10 justify-between items-center">
            <ul class="flex space-x-6">
                <li><a href="#" class="hover:text-gray-300">Best Sellers</a></li>
                <li><a href="{{ url('/about') }}" class="hover:text-gray-300">About</a></li>
                <li><a href="#" class="hover:text-gray-300">Shop</a></li>
                <li><a href="#" class="hover:text-gray-300">Gifts</a></li>
            </ul>

            <!-- Icons -->
            <div class="flex items-center space-x-4 ml-6">
                <a href="#"><i class="fas fa-user text-lg"></i></a>
                <button @click="searchOpen = !searchOpen"><i class="fas fa-search text-lg"></i></button>
                <a href="#"><i class="fas fa-shopping-cart text-lg"></i></a>
            </div>
        </nav>

        <!-- Hamburger (Mobile) -->
        <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="menuOpen" x-transition class="md:hidden bg-teal-800 px-6 py-4">
        <ul class="flex flex-col space-y-4">
            <li><a href="#" class="hover:text-gray-300">Best Sellers</a></li>
            <li><a href="#" class="hover:text-gray-300">About</a></li>
            <li><a href="#" class="hover:text-gray-300">Shop</a></li>
            <li><a href="#" class="hover:text-gray-300">Gifts</a></li>
        </ul>
        <div class="flex mt-4 space-x-4 text-xl">
            <a href="#"><i class="fas fa-user"></i></a>
            <button @click="searchOpen = !searchOpen"><i class="fas fa-search"></i></button>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>

    <!-- Search Overlay -->
    <div x-show="searchOpen" x-transition
        class="absolute top-full left-0 w-full bg-white text-black flex items-center px-6 py-3 z-50">
        <i class="fas fa-search mr-3"></i>
        <input type="text" placeholder="Search..." class="w-full bg-transparent outline-none">
        <button @click="searchOpen = false" class="ml-4 text-xl"><i class="fas fa-times"></i></button>
    </div>
</header>



    <!-- Bagian Konten -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#A89F91] py-6 px-6 md:px-10">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start gap-y-8 md:gap-x-10">
            <div class="md:w-1/3">
                <h2 class="text-3xl font-bold">THANKS!</h2>
                <p class="text-sm">For Visiting Our Website</p>
                <p class="text-sm mt-2 text-[#C3BABA]">© 2025 By Scentscape.</p>
            </div>

            <div class="md:w-1/3">
                <h2 class="text-base font-bold">About Scentscape</h2>
                <p class="text-sm">
                    Scentscape offers thoughtfully crafted fragrances for everyone. We focus on quality ingredients and timeless scents that bring confidence and comfort in every wear.
                </p>
            </div>

            <div class="md:w-1/3">
                <h2 class="text-base font-bold">Contact Us</h2>
                <div class="flex items-center mt-2 space-x-4 text-lg">
                    <i class="fas fa-envelope"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>