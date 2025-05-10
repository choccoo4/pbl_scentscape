{{-- resources/views/components/product-card.blade.php --}}
@props([
'name',
'price',
'image',
'gender' => 'Unisex', // Label seperti "For Her"
'volume' => '50ml', // Misalnya: 50ml
'type' => 'EDP', // EDP, EDT, dsb.
'aromas' => [], // Array ikon aroma
'extraClass' => '',
])

<div class="rounded-md overflow-hidden shadow-sm border border-gray-200 {{ $extraClass }}">
    <div class="aspect-square bg-white">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
    </div>

    <div class="p-3 space-y-2">
        <!-- Nama & Harga -->
        <div class="text-center">
            <h3 class="font-poppins text-sm text-gray-800 font-semibold">{{ $name }}</h3>
            <p class="font-poppins text-sm text-gray-600">{{ $price }}</p>
        </div>

        <!-- Informasi Tambahan -->
        <div class="text-xs text-gray-600 flex flex-col gap-1">
            <!-- Gender Label -->
            <span class="inline-block px-2 py-0.5 bg-[#9BAF9A] text-white rounded-full w-max text-[10px] uppercase tracking-wider">
                {{ $gender }}
            </span>

            <!-- Volume & Type -->
            <div class="flex justify-between text-[11px]">
                <span>{{ $volume }}</span>
                <span>{{ $type }}</span>
            </div>

            <!-- Aroma Icons -->
             <div class="flex gap-2 text-lg mt-1">
                @foreach ($aromas as $aroma)
                <div class="relative group">
                    <!-- Aroma Icon with Button for hover and active -->
                     <button
                     type="button"
                     data-tooltip-target="tooltip-{{ Str::slug($name) }}-{{ $aroma['icon'] }}"
                     data-tooltip-placement="top"
                     class="relative p-2 rounded-full hover:text-green-700 active:text-red-500 transition duration-200"
                     >
                     <i class="ph ph-{{ $aroma['icon'] }} cursor-pointer"></i>
                    </button>
                    
                    <!-- Tooltip -->
                     <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 w-max px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition duration-200 z-10">
                        {{ $aroma['label'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>