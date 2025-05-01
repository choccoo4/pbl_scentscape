@extends('layouts.app')
@section('title', 'About - Scentscape')
@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-16 px-6 md:px-20 text-[#3E3A39]">

    <!-- Hero Section -->
    <div class="grid md:grid-cols-2 gap-10 items-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/about.png') }}" alt="Perfume Display" class="rounded-xl w-80 drop-shadow-lg">
        </div>
        <div>
            <h1 class="text-4xl font-semibold mb-4">Welcome to Scentscape</h1>
            <p class="mb-4 text-lg leading-relaxed">
                Scentscape is more than a marketplace. It's a journey through scents, emotions, and identity.
                We connect fragrance lovers with authentic, curated perfumes, designed to elevate every moment.
            </p>
            <p class="mb-4 text-lg leading-relaxed">
                Whether you're discovering your first signature scent or curating a collection, we’re here to
                ensure it's safe, easy, and delightful.
            </p>
            <p class="text-lg leading-relaxed">
                Discover, buy, and sell fragrances effortlessly — only at Scentscape.
            </p>
        </div>
    </div>

    <!-- Our Story -->
    <div class="mt-24 text-center">
        <h2 class="text-3xl font-semibold mb-6">The Story Behind Scentscape</h2>
        <p class="max-w-3xl mx-auto text-lg leading-relaxed">
            Scents are memories bottled. Scentscape was born from a desire to preserve emotions in bottles —
            to bring people closer to moments, feelings, and identity through authentic fragrances.
        </p>
    </div>

    <!-- Our Values -->
    <div class="mt-24 text-center">
        <h2 class="text-3xl font-semibold mb-10">What We Believe</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
            <div class="p-6 bg-[#FFF9F1] rounded-xl shadow-sm">
                <div class="text-3xl mb-3">🌿</div>
                <h3 class="text-xl font-medium mb-2">Authenticity</h3>
                <p class="text-sm leading-relaxed">All perfumes on our platform are 100% original and verified.</p>
            </div>
            <div class="p-6 bg-[#FFF9F1] rounded-xl shadow-sm">
                <div class="text-3xl mb-3">🔒</div>
                <h3 class="text-xl font-medium mb-2">Security</h3>
                <p class="text-sm leading-relaxed">Secure transactions and safe delivery, every single time.</p>
            </div>
            <div class="p-6 bg-[#FFF9F1] rounded-xl shadow-sm">
                <div class="text-3xl mb-3">🤝</div>
                <h3 class="text-xl font-medium mb-2">Community</h3>
                <p class="text-sm leading-relaxed">We're building a trusted fragrance-loving community.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="mt-24 text-center">
        <h2 class="text-3xl font-semibold mb-10">What People Say</h2>
        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl p-6">
            <p class="italic text-lg">"Finally found my signature scent here. Amazing platform!"</p>
            <p class="mt-4 font-semibold">– Rani, Jakarta</p>
        </div>
    </div>

</div>
@endsection
