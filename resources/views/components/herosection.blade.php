{{-- resources/views/components/hero.blade.php --}}
<div class="relative h-[400px] md:h-[500px] lg:h-[550px] overflow-hidden">
    <img src="{{ $background }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover z-0" />
    <div class="absolute inset-0 bg-black/30 z-10"></div>
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <h1 class="text-2xl md:text-4xl font-semibold mb-3">{{ $title }}</h1>
        <p class="text-sm md:text-lg max-w-xl leading-relaxed">{!! $subtitle !!}</p>
    </div>
</div>
