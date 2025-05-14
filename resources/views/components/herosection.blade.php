{{-- resources/views/components/hero.blade.php --}}
<section
    class="bg-center bg-no-repeat bg-cover bg-gray-700 bg-blend-multiply"
    style="background-image: url('{{ $background }}'); background-color: rgba(0, 0, 0, 0.3);">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <h1 class="mb-4 text-3xl font-bold tracking-tight leading-tight text-white md:text-4xl lg:text-5xl">
            {!! $title !!}
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
            {!! $subtitle !!}
        </p>
    </div>
</section>