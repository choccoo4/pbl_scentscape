<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Halaman Login</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-teal-900 min-h-screen flex flex-col items-center justify-center">

    <!-- Logo di area hijau -->
    <img src="{{ asset('images/Scentscape.png') }}" alt="Logo Scentscape" class="mb-1 h-13">

    <!-- Box login -->
    <div class="bg-[#FFFFFF] p-8 rounded-2xl shadow-lg w-76 text-center">
        <h2 class="text-[#000000] text-xs mb-4 ">Login to see our products!</h2>
        @if(session('success'))
    <div class="mb-4 text-green-600 text-sm">
        {{ session('success') }}
    </div>
@endif 
        
        <form method="POST" action="#">
            @csrf
            <!-- Username with Right Icon -->
<div class="mb-4">
  <div class="flex items-center bg-[#F1EAEA] rounded-md px-4 py-2">
    <input 
      type="text" 
      placeholder="Username" 
      class="flex-1 bg-transparent placeholder:text-[#b1a79e] text-sm focus:outline-none"
    />
    <i class="fa-solid fa-id-badge text-[#9c9491]"></i>
  </div>
</div>

<!-- Password with Right Icon -->
<div class="mb-4">
  <div class="flex items-center bg-[#F1EAEA] rounded-md px-4 py-2">
    <input 
      type="password" 
      placeholder="Password" 
      class="flex-1 bg-transparent placeholder:text-[#b1a79e] text-sm focus:outline-none"
    />
    <i class="fa-solid fa-lock text-[#9c9491]"></i>
  </div>
</div>

            <button 
                class="w-full bg-[#F1EAEA] hover:bg-[#d6cfc7] text-[#000000] text-sm py-2 rounded-md"
            >
                Login
            </button>
        </form>

        <p class="text-xs mt-4 text-[#000000]">
            New here? <a href="{{ route('register') }}" class="underline">Create an account</a>
        </p>
    </div>
</body>
</html>
