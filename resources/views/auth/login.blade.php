<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Scentscape</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

@php $bg = asset('images/background3.jpeg'); @endphp

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center relative"
  style="background-image: url('{{ $bg }}');">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  <!-- Login Box -->
  <div class="relative z-10 bg-white/80 backdrop-blur-md shadow-xl rounded-2xl px-8 py-10 w-full max-w-md text-center" x-data="loginForm()">
    <img src="{{ asset('images/Scentscape1.png') }}" alt="Scentscape Logo" class="mx-auto h-12 mb-6">

    <h2 class="text-[#3E3A39] text-lg font-semibold mb-2">Welcome Back</h2>
    <p class="text-sm text-[#3E3A39]/70 mb-6 italic">"Fragrance is the voice of memory and soul."</p>

    @if(session('success'))
    <div class="mb-4 text-green-600 text-sm">{{ session('success') }}</div>
    @endif

    <form @submit.prevent="submitForm">
      @csrf

      <!-- Email Field -->
      <div class="mb-5 relative">
        <input
          type="text"
          name="email"
          placeholder="Email"
          class="w-full p-3 rounded-md bg-[#F6F1EB] placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="email" />
        <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <p x-show="errors.email" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.email"></p>
      </div>

      <!-- Password Field -->
      <div class="mb-6 relative">
        <input
          type="password"
          name="password"
          placeholder="Password"
          class="w-full p-3 rounded-md bg-[#F6F1EB] placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="password" />
        <i class="fa-solid fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <p x-show="errors.password" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.password"></p>
      </div>

      <button
        type="submit"
        class="w-full bg-[#414833] text-white font-semibold py-2 rounded-md hover:bg-[#8da48c] transition-all duration-200">
        Login
      </button>
    </form>

    <p class="text-xs mt-6 text-[#3E3A39]">
      New here?
      <a href="{{ route('register') }}" class="underline hover:text-[#9BAF9A] transition">Create an account</a>
    </p>
  </div>
</body>

</html>