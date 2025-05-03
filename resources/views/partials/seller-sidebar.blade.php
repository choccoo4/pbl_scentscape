<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-52 bg-[#4f5742] text-white flex flex-col justify-between pt-6 pb-4">
    <nav class="space-y-2 px-4">
      <a href="{{ route('dashboard') }}"
        class="block py-2 px-4 hover:bg-[#9baf9a] rounded {{ request()->is('dashboard') ? 'bg-[#9baf9a]' : '' }}">
        <i class="fa-solid fa-gauge mr-5"></i>Dashboard
      </a>

      <a href="{{ route('produk.index') }}"
        class="block py-2 px-4 hover:bg-[#9baf9a] rounded {{ request()->is('produk*') ? 'bg-[#9baf9a]' : '' }}">
        <i class="fa-solid fa-box mr-5" style="color: #ffffff;"></i>Produk
      </a>

      <a href="{{ route('pesanan.index') }}"
        class="block py-2 px-4 hover:bg-[#9baf9a] rounded {{ request()->is('pesanan*') ? 'bg-[#9baf9a]' : '' }}">
        <i class="fa-solid fa-clipboard-list mr-5" style="color: #ffffff;"></i>Pesanan
      </a>

      <a href="{{ route('rekap.index') }}"
        class="flex items-center gap-2 py-2 px-4 hover:bg-[#9baf9a] rounded {{ request()->is('rekap*') ? 'bg-[#9baf9a]' : '' }}">
        <i class="fa-solid fa-chart-line mr-3" style="color: #ffffff;"></i>Rekapitulasi Penjualan
      </a>
    </nav>
  </aside>
</div>