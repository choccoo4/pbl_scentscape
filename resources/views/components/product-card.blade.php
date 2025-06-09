@props([
'id',
'name',
'price',
'image',
'gender',
'volume',
'type',
'type_full',
'aroma',
'slug',
'extraClass' => '',
])

<div class="rounded-xl overflow-hidden shadow-md border border-[#D6C6B8] bg-[#F6F1EB] transition-transform duration-300 hover:scale-[1.02] hover:shadow-lg {{ $extraClass }} w-full max-w-[250px] mx-auto group">
    <!-- Gambar Produk + Overlay -->
    <div class="aspect-square bg-[#F6F1EB] relative group">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover transition duration-300 group-hover:brightness-105">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center gap-3">
            <!-- Lihat Detail -->
            <a href="{{ route('produk.show', $id) }}"
                class="bg-white text-[#3E3A39] p-2 rounded-full shadow hover:bg-[#D6C6B8] transition"
                data-tooltip-target="tooltip-detail-{{ Str::slug($name) }}">
                <i class="ph ph-eye text-lg"></i>
            <div id="tooltip-detail-{{ Str::slug($name) }}"
                role="tooltip"
                class="absolute z-10 invisible px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-md shadow tooltip dark:bg-gray-700">
                Lihat Detail
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            </a>

            <!-- Tambah ke Keranjang -->
            <button type="button"
                class="bg-[#9BAF9A] text-white p-2 rounded-full shadow hover:bg-[#819d80] transition"
                data-tooltip-target="tooltip-cart-{{ Str::slug($name) }}">
                <i class="ph ph-shopping-cart-simple text-lg"></i>
            </button>
            <div id="tooltip-cart-{{ Str::slug($name) }}"
                role="tooltip"
                class="absolute z-10 invisible px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-md shadow tooltip dark:bg-gray-700">
                Tambah ke Keranjang
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>

    <div class="p-3 space-y-3">
        <!-- Nama & Harga -->
        <div class="text-center">
            <h3 class="font-poppins text-sm text-[#3E3A39] font-semibold line-clamp-2">{{ $name }}</h3>
            <p class="font-poppins text-sm text-[#9E7D60] font-medium">{{ $price }}</p>
        </div>

        <!-- Informasi Tambahan -->
        <div class="text-xs text-[#3E3A39] space-y-1">
            <!-- Gender + Type -->
            <div class="flex justify-between items-center text-[10px] font-semibold tracking-wide">
                <span class="px-2 py-0.5 bg-[#9BAF9A] text-white rounded-full shadow-sm">{{ $gender }}</span>

                <div class="relative">
                    <button
                        type="button"
                        data-tooltip-target="tooltip-type-{{ Str::slug($name) }}"
                        data-tooltip-placement="top"
                        class="text-[10px] font-medium text-[#3E3A39] hover:text-[#9BAF9A] transition">
                        {{ $type }}
                    </button>
                    <div id="tooltip-type-{{ Str::slug($name) }}"
                        role="tooltip"
                        class="absolute z-10 invisible px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-md shadow tooltip dark:bg-gray-700">
                        {{ $type_full }}
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </div>

            <!-- Volume + Aroma -->
            <div class="flex justify-between items-center text-[11px]">
                <span>{{ $volume }}</span>
                <div class="flex gap-1">
                    @foreach ($aroma as $index => $item)
                    <div class="relative">
                        <button
                            type="button"
                            data-tooltip-target="tooltip-aroma-{{ Str::slug($name) }}-{{ $index }}"
                            data-tooltip-placement="top"
                            class="text-lg text-[#3E3A39] hover:text-[#9BAF9A] transition">
                            <i class="ph {{ $item['icon'] }}"></i>
                        </button>
                        <div id="tooltip-aroma-{{ Str::slug($name) }}-{{ $index }}"
                            role="tooltip"
                            class="absolute z-10 invisible px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700">
                            {{ $item['label'] }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>