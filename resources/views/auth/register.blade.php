<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register - Scentscape</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

@php $bg = asset('images/background3.jpeg'); @endphp

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center relative"
  style="background-image: url('{{ $bg }}');">

  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
  <div class="absolute w-96 h-96 bg-[#BFA6A0]/30 rounded-full blur-3xl -top-20 -left-20 z-0"></div>
  <div class="absolute w-80 h-80 bg-[#9BAF9A]/40 rounded-full blur-2xl bottom-0 right-0 z-0"></div>

  <div class="relative z-10 bg-white/80 backdrop-blur-md shadow-xl rounded-2xl px-8 py-10 w-full max-w-md text-center" x-data="registerForm()">
    <img src="{{ asset('images/Scentscape1.png') }}" alt="Scentscape Logo" class="h-12 mx-auto mb-4">
    <h2 class="text-[#3E3A39] text-sm font-medium mb-6">Create an account to explore aromatic elegance</h2>

    <form @submit.prevent="submitForm">
      @csrf

      <!-- Email -->
      <div class="mb-5 relative">
        <input type="email" name="email" placeholder="Email"
          class="w-full pl-10 pr-3 py-2 rounded-md bg-gray-100 placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="email" />
        <i class="fa-solid fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <p x-show="errors.email" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.email"></p>
      </div>

      <!-- Name -->
      <div class="mb-5 relative">
        <input type="text" name="name" placeholder="Name"
          class="w-full pl-10 pr-3 py-2 rounded-md bg-gray-100 placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="name" />
        <i class="fa-solid fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <p x-show="errors.name" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.name"></p>
      </div>

      <!-- Username -->
      <div class="mb-5 relative">
        <input type="text" name="username" placeholder="Username"
          class="w-full pl-10 pr-3 py-2 rounded-md bg-gray-100 placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="username" />
        <i class="fa-solid fa-id-badge absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <p x-show="errors.username" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.username"></p>
      </div>

      <!-- Password -->
      <div class="mb-6 relative" x-data="{ show: false }">
        <input :type="show ? 'text' : 'password'" name="password" placeholder="Password" autocomplete="new-password"
          class="w-full pl-10 pr-10 py-2 rounded-md bg-gray-100 placeholder:text-gray-500 text-sm border border-gray-300 focus:outline-none"
          x-model="password" />
        <i class="fa-solid fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <i @click="show = !show" :class="show ? 'fa-eye' : 'fa-eye-slash'" class="fa-solid absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer"></i>
        <p x-show="errors.password" class="text-xs text-red-500 mt-1 absolute -bottom-4 left-0" x-text="errors.password"></p>
      </div>

      <button type="submit" class="w-full bg-[#414833] hover:bg-[#88a288] text-white py-2 rounded-md font-semibold transition duration-200">
        Sign Up
      </button>
    </form>

    <p class="text-xs mt-5 text-[#3E3A39]">
      Already have an account? <a href="{{ route('login') }}" class="underline hover:text-[#9BAF9A]">Login</a>
    </p>
  </div>
</body>

</html>
