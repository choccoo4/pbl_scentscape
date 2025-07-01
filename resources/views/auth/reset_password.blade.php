<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Reset Password - Scentscape</title>

  {{-- Meta --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="reset-success" content="{{ session('reset_success') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/auth/reset.js'])

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

@php
$bg = asset('images/background3.jpeg');
@endphp

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center relative"
  style="background-image: url('{{ $bg }}');">

  {{-- Overlay --}}
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  {{-- Reset Box --}}
  <div class="relative z-10 bg-white/80 backdrop-blur-md shadow-xl rounded-2xl px-8 py-10 w-full max-w-md text-center">
    <img src="{{ asset('images/Scentscape1.png') }}" alt="Scentscape Logo" class="mx-auto h-12 mb-6">

    <h2 class="text-[#3E3A39] text-lg font-semibold mb-2">Reset Password</h2>
    <p class="text-sm text-[#3E3A39]/70 mb-6 italic">"Fragrance is the voice of memory and soul."</p>

    {{-- Reset Form --}}
    <form method="POST" action="{{ url('/reset-password/'.$token.'?email='.$email) }}">
      @csrf

      {{-- Email --}}
      <div class="mb-5 relative">
        <input
          type="email"
          name="email"
          value="{{ $email }}"
          readonly
          class="w-full p-3 rounded-md bg-[#F6F1EB] text-gray-700 text-sm border border-gray-300 focus:outline-none cursor-not-allowed"
          placeholder="Email" />
        <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
      </div>

      {{-- New Password --}}
      <div class="mb-5 relative" x-data="{ show: false }">
        <input
          :type="show ? 'text' : 'password'"
          name="password"
          autocomplete="new-password"
          required
          placeholder="New Password"
          class="w-full p-3 rounded-md bg-[#F6F1EB] text-sm border border-gray-300 focus:outline-none" />
        <i @click="show = !show"
          :class="show ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash'"
          class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
      </div>

      {{-- Confirm Password --}}
      <div class="mb-6 relative" x-data="{ showConfirm: false }">
        <input
          :type="showConfirm ? 'text' : 'password'"
          name="password_confirmation"
          required
          placeholder="Confirm Password"
          class="w-full p-3 rounded-md bg-[#F6F1EB] text-sm border border-gray-300 focus:outline-none" />
        <i @click="showConfirm = !showConfirm"
          :class="showConfirm ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash'"
          class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
      </div>

      {{-- Submit --}}
      <button
        type="submit"
        class="w-full bg-[#414833] text-white font-semibold py-2 rounded-md hover:bg-[#8da48c] transition-all duration-200">
        Reset Password
      </button>
    </form>

    <p class="text-xs mt-6 text-[#3E3A39]">
      Remember your old password?
      <a href="{{ route('login') }}" class="underline hover:text-[#9BAF9A] transition">Login Now</a>
    </p>
  </div>
</body>

</html>
