@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-[#FDF6EF] min-h-screen py-12">
    <div class="flex max-w-6xl mx-auto gap-6">

        <!-- Sidebar -->
        <aside class="w-[180px] shrink-0 bg-[#FDF6EF] p-6">
            <div class="flex items-center gap-4 mb-6 px-2">
                <img src="{{ $pembeli->pengguna && $pembeli->pengguna->foto_profil ? asset('storage/' . $pembeli->pengguna->foto_profil) : asset('/images/profile.png') }}" 
                     class="w-10 h-10 rounded-full" alt="Profile Icon">
                <p class="font-semibold text-lg">{{ $pembeli->nama_pembeli ?? Auth::user()->nama ?? 'User' }}</p>
            </div>

            <ul class="space-y-2 text-left font-medium ml-4 group">
                <li class="relative">
                    <div class="flex items-center space-x-2 hover:text-[#9BAF9A] transition-all cursor-pointer group-hover:text-[#9BAF9A]">
                        <i class="fas fa-user"></i>
                        <span>My Account</span>
                    </div>
                    <ul class="pl-6 mt-2 space-y-1 text-sm transition-all duration-300 group-hover:max-h-32 max-h-0 overflow-hidden">
                        <li><a href="{{ route('profile') }}" class="hover:text-[#BFA6A0]">Profile</a></li>
                        <li><a href="{{ route('change-pw') }}" class="hover:text-[#BFA6A0]">Change Password</a></li>
                    </ul>
                </li>
                <li class="flex items-center space-x-2 font-medium text-black hover:text-[#9BAF9A]">
                    <i class="fas fa-box"></i>
                    <a href="{{ route('order.history') }}">Order History</a>
                </li>
            </ul>
        </aside>

        <!-- Main Profile Content -->
        <section class="w-full md:flex-1 bg-white p-6 md:p-10 rounded-lg shadow-md mx-0 md:mx-6 mt-6 md:mt-0">
            
            <!-- Greeting -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-[#3E3A39]">Welcome back, 
                    <span class="text-[#9BAF9A]">{{ old('nama_pembeli', $pembeli->nama_pembeli ?? Auth::user()->nama ?? 'User') }}</span>!
                </h2>
                <p class="text-sm text-gray-500">Update your profile to keep everything up-to-date ✨</p>
            </div>

            <!-- Profile Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture -->
                <div class="text-center mb-8">
                    <img id="profilePicPreview" 
                         src="{{ $pembeli->pengguna && $pembeli->pengguna->foto_profil ? asset('storage/' . $pembeli->pengguna->foto_profil) : asset('/images/profile.png') }}"
                         class="w-24 h-24 rounded-full border-4 border-[#D6C6B8] mx-auto mb-2 shadow-md"
                         alt="Profil Pembeli">
                    <label for="profilePicInput" class="text-sm text-[#9BAF9A] hover:underline cursor-pointer block">
                        ✎ Change profile picture
                    </label>
                    <input id="profilePicInput" type="file" name="foto_profil" class="hidden" accept="image/*">
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-user text-[#BFA6A0]"></i> Name
                    </label>
                    <input type="text" name="nama_pembeli" class="w-full border px-4 py-2 rounded" required
                           value="{{ old('nama_pembeli', $pembeli->nama_pembeli ?? '') }}">
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-phone text-[#BFA6A0]"></i> Phone Number
                    </label>
                    <input type="text" name="no_telp" class="w-full border px-4 py-2 rounded"
                           value="{{ old('no_telp', $pembeli->no_telp ?? '') }}">
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-[#BFA6A0]"></i> Address
                    </label>
                    <textarea name="alamat" class="w-full border px-4 py-2 rounded" rows="4">{{ old('alamat', $pembeli->alamat ?? '') }}</textarea>
                </div>

                <button type="submit" class="bg-[#9BAF9A] text-white px-6 py-2 rounded hover:bg-[#8aa38a] transition-colors">
                    Save
                </button>
            </form>

            <!-- Divider -->
            <hr class="my-8 border-[#E5DAD2]">

            <!-- Extra Info Section -->
            <div class="text-sm text-gray-500 italic">
                <p>📅 Last updated: 
                    <span class="text-[#BFA6A0]">
                        {{ $pembeli->pengguna && $pembeli->pengguna->waktu_perubahan 
                            ? $pembeli->pengguna->waktu_perubahan->setTimezone('Asia/Jakarta')->format('d F Y H:i:s') 
                            : '-' }}
                    </span>
                </p>
                <p class="mt-1">💡 Tip: Keeping your info up-to-date helps with smooth checkout and delivery!</p>
            </div>
        </section>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Notifications -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '{{ session('success') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
</script>
@endif

<!-- Script untuk preview foto -->
<script>
document.getElementById('profilePicInput').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('profilePicPreview').src = URL.createObjectURL(file);
    }
});
</script>
@endsection
