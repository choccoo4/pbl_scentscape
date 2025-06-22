@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center items-center space-x-1 text-sm mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-[#9BAF9A] text-white rounded hover:bg-[#819b83] transition">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-[#3E3A39] text-white rounded font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-[#3E3A39] hover:bg-[#E5DED6] rounded transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-[#9BAF9A] text-white rounded hover:bg-[#819b83] transition">&raquo;</a>
        @else
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded">&raquo;</span>
        @endif
    </nav>
@endif
