<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Halaman Register</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body class="bg-teal-900 min-h-screen flex flex-col items-center justify-start pt-12">
    
    <!-- Logo di atas background hijau -->
    <img src="{{ asset('images/Scentscape.png') }}" alt="Logo Scentscape" class="h-13 mb-1">

    <!-- Kotak Form Registrasi -->
    <div class="bg-white p-8 rounded-2xl shadow-lg w-76 text-center">
        <h2 class="text-[#4a4a4a] text-xs mb-4">Sign up to see our products!</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3 relative">
  <input 
    type="text" name="email" placeholder="Email"
    class="w-full pl-10 pr-10 p-4 py-2 rounded-md bg-[#F1EAEA] placeholder:text-[#b1a79e] text-sm focus:outline-none"
  />
  <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
</div>

 <!-- Name -->
  <div class="mb-3 relative">
  <input 
    type="text" name="name" placeholder="Name"
    class="w-full pl-10 pr-10 p-4 py-2 rounded-md bg-[#F1EAEA] placeholder:text-[#b1a79e] text-sm focus:outline-none"
  />
  <i class="fa-solid fa-user absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
</div>

            <!-- Username -->
            <div class="mb-3 relative">
  <input 
    type="text" name="username" placeholder="Username"
    class="w-full pl-10 pr-10 p-4 py-2 rounded-md bg-[#F1EAEA] placeholder:text-[#b1a79e] text-sm focus:outline-none"
  />
  <i class="fa-solid fa-id-badge absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
</div>
<!-- Password -->
<div class="mb-4 relative">
  <input 
    type="password" name="password" placeholder="Password"
    class="w-full pr-10 pl-10 p-4 py-2 rounded-md bg-[#F1EAEA] placeholder:text-[#b1a79e] text-sm focus:outline-none"
  />
  <i class="fa-solid fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
</div>

            <button 
                class="w-full bg-[#F1EAEA] hover:bg-[#d6cfc7] text-[#4a4a4a] py-2 rounded-md font-semibold"
            >
                Sign Up
            </button>
        </form>

        <p class="text-xs mt-4 text-[#4a4a4a]">
            Have an account? <a href="{{ route('login') }}" class="underline">Login</a>
        </p>
    </div>
</body>
</html>