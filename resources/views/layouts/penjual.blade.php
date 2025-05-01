<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Scentscape')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  @vite('resources/css/app.css')
</head>
<body class="bg-[#f2ede4] text-gray-800 font-serif">

  <!-- Navbar -->
  <div class="flex items-center justify-between bg-[#014d4e] px-6 py-3 shadow">
    <div class="flex items-center gap-4">
    <img src="{{ asset('images/Scentscape.png') }}" alt="Scentscape Logo" class="h-13 w-auto">
    </div>
    <div class="w-1/2 relative bg-white rounded-lg">
      <input
      type="text"
      placeholder="Cari produk berdasarkan nama"
      class="w-full px-4 py-2 pr-10 rounded-lg text-sm focus:outline-none"
      />
      <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300">
        <i class="fa-solid fa-magnifying-glass"></i>
      </span>
    </div>

    <div class="text-white flex items-center gap-2">
    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
      <span class="text-sm">
Profile</span>
    </div>
  </div>

  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-60 bg-[#014d4e] text-white flex flex-col justify-between pt-6 pb-4">
  <nav class="space-y-2 px-4">
    <a href="{{ route('dashboard') }}"
       class="block py-2 px-4 hover:bg-[#0f766e] rounded {{ request()->is('dashboard') ? 'bg-[#0f766e]' : '' }}">
      <i class="fa-solid fa-gauge mr-5"></i>Dashboard
    </a>

    <a href="{{ route('produk.index') }}"
       class="block py-2 px-4 hover:bg-[#0f766e] rounded {{ request()->is('produk*') ? 'bg-[#0f766e]' : '' }}">
       <i class="fa-solid fa-box mr-5" style="color: #ffffff;"></i>Produk
    </a>

    <a href="{{ route('pesanan.index') }}"
       class="block py-2 px-4 hover:bg-[#0f766e] rounded {{ request()->is('pesanan*') ? 'bg-[#0f766e]' : '' }}">
       <i class="fa-solid fa-clipboard-list mr-5" style="color: #ffffff;"></i>Pesanan
    </a>

    <a href="{{ route('rekap.index') }}"
       class="flex items-center gap-2 py-2 px-4 hover:bg-[#0f766e] rounded {{ request()->is('rekap*') ? 'bg-[#0f766e]' : '' }}">
       <i class="fa-solid fa-chart-line mr-3" style="color: #ffffff;"></i>Rekapitulasi Penjualan
    </a>


    <a href="#"
       class="block py-2 px-4 hover:bg-[#0f766e] rounded {{ request()->is('pengaturan*') ? 'bg-[#0f766e]' : '' }}">
       <i class="fa-solid fa-gear mr-5" style="color: #ffffff;"></i>Pengaturan Toko
    </a>
  </nav>

  <div class="px-4">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit"
              class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 rounded text-center">
        Logout
      </button>
    </form>
  </div>
</aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
