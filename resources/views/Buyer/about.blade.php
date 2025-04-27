@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF6EF] py-10 px-6 md:px-20">
    <div class="grid md:grid-cols-2 gap-10 items-center">
        <!-- Gambar -->
        <div class="flex justify-center">
            <img src="{{ asset('images/about.png') }}" alt="Perfume Display" class="rounded  w-60 max-w-sm mt-10 -ml-60">
        </div>

        <!-- Teks -->
        <div class="-ml-60 mt-10">
    <h1 class="text-2xl font-semibold mb-6">Welcome to ScentScape!</h1>
    <p class="mb-6">
        ScanScape is your go-to platform for buying and selling authentic <br> perfumes easily and securely.We connect fragrance lovers with<br> trusted sellers, ensuring a smooth shopping experience.
    </p>
    <p class="mb-6">
        With a wide range of verified perfumes, we make it simple to find your<br> perfect scent. Our mission is to create a safe, user-friendly, and<br> reliable marketplace for all perfume <br>enthusiasts.
    </p>
    <p>
        Discover, buy, and sell perfumes effortlessly—only at ScanScape!
    </p>
</div>

    </div>
</div>
@endsection
