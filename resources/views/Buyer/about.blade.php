@extends('layouts.app')

@section('title', 'About - Scentscape')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-16 px-6 md:px-20 text-[#3E3A39]">

    <!-- Hero Section -->
    <div class="grid md:grid-cols-2 gap-12 items-start max-w-7xl mx-auto">
        <div class="flex justify-center">
            @if ($penjual && $penjual->pengguna && $penjual->pengguna->foto_profil)
                <img src="{{ asset('storage/' . $penjual->pengguna->foto_profil) }}" 
                     alt="Foto Toko"
                     class="rounded-xl w-80 drop-shadow-lg object-cover">
            @else
                <img src="{{ asset('images/about.png') }}" 
                     alt="Perfume Display"
                     class="rounded-xl w-80 drop-shadow-lg object-cover">
            @endif
        </div>
        
        <div class="space-y-6">
            <div>
                <h1 class="text-4xl font-semibold mb-6">
                    Welcome to {{ $penjual && $penjual->pengguna ? $penjual->pengguna->nama : 'Scentscape' }}
                </h1>
                <div class="pr-0 md:pr-4">
                    <div class="mb-6 text-lg leading-relaxed text-justify">
                        {!! $penjual && $penjual->deskripsi_toko 
                            ? nl2br(e($penjual->deskripsi_toko))
                            : "Scentscape is more than a marketplace. It's a journey through scents, emotions, and identity. We connect fragrance lovers with authentic, curated perfumes, designed to elevate every moment." 
                        !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Sections (if needed) -->
    <div class="max-w-7xl mx-auto mt-16">
        <!-- You can add more sections here like mission, vision, etc. -->
    </div>

</div>
@endsection