<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="reset-status" content="{{ session('status') }}">
  <meta name="reset-error" content="{{ $errors->first('email') }}">

  <title>Reset Password - Scentscape</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

@php $bg = asset('images/background3.jpeg'); @endphp

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center relative"
      style="background-image: url('{{ $bg }}');">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  <!-- Reset Box -->
  <div class="relative z-10 bg-white/80 backdrop-blur-md shadow-xl rounded-2xl px-8 py-10 w-full max-w-md text-center">
    <img src="{{ asset('images/Scentscape1.png') }}" alt="Scentscape Logo" class="mx-auto h-12 mb-6">

    <h2 class="text-[#3E3A39] text-lg font-semibold mb-2">Welcome Back</h2>
    <p class="text-sm text-[#3E3A39]/70 mb-6 italic">"Fragrance is the voice of memory and soul."</p>

    <form method="POST" action="{{ url('/forgot-password') }}">
      @csrf
      <div class="mb-5 relative">
        <input
          type="email"
          name="email"
          placeholder="Email"
          autocomplete="new-password"
          required
          class="w-full p-3 rounded-md bg-[#F6F1EB] placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none" />
        <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
      </div>

      <button
        type="submit"
        class="w-full bg-[#414833] text-white font-semibold py-2 rounded-md hover:bg-[#8da48c] transition-all duration-200">
        Kirim Link Reset
      </button>
    </form>

    <p class="text-xs mt-6 text-[#3E3A39]">
      Sudah ingat?
      <a href="{{ route('login') }}" class="underline hover:text-[#9BAF9A] transition">Kembali ke Login</a>
    </p>
  </div>




</body>
</html>
