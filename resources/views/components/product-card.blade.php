{{-- resources/views/components/product-card.blade.php --}}
@props([
    'name',
    'price',
    'image',
    'gender' => 'Unisex',
    'volume' => '50ml',
    'type' => 'EDP',
    'aromas' => [],
    'extraClass' => '',
])

<div class="rounded-md overflow-hidden shadow-sm border border-gray-200 bg-white {{ $extraClass }} w-full max-w-[220px] mx-auto">
    <div class="aspect-square bg-white">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
    </div>

    <div class="p-3 space-y-2">
        <!-- Nama & Harga -->
        <div class="text-center">
            <h3 class="font-poppins text-sm text-gray-800 font-semibold line-clamp-2">{{ $name }}</h3>
            <p class="font-poppins text-sm text-gray-600">{{ $price }}</p>
        </div>

        <!-- Informasi Tambahan -->
        <div class="text-xs text-gray-600 flex flex-col gap-1">
            <span class="inline-block px-2 py-0.5 bg-[#9BAF9A] text-white rounded-full w-max text-[10px] uppercase tracking-wider">
                {{ $gender }}
            </span>

            <div class="flex justify-between text-[11px]">
                <span>{{ $volume }}</span>
                <span>{{ $type }}</span>
            </div>

            <!-- Aroma Icons -->
            <div class="flex gap-2 text-lg mt-1 flex-wrap">
                @foreach ($aromas as $aroma)
                    <div class="relative">
                        <button
                            type="button"
                            data-tooltip-target="tooltip-{{ Str::slug($name) }}-{{ $aroma['icon'] }}"
                            data-tooltip-placement="top"
                            class="p-2 rounded-full hover:text-green-700 active:text-red-500 transition duration-200"
                        >
                            <i class="ph ph-{{ $aroma['icon'] }}"></i>
                        </button>
                        <div id="tooltip-{{ Str::slug($name) }}-{{ $aroma['icon'] }}"
                             role="tooltip"
                             class="absolute z-10 invisible inline-block px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700">
                            {{ $aroma['label'] }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
