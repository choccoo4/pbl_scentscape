@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Pembeli;

    $pembeli = Pembeli::with('pengguna')->where('id_pengguna', Auth::id())->first();
@endphp

<aside class="w-[180px] shrink-0 bg-[#FDF6EF] p-6">
    <div class="flex items-center gap-4 mb-6 px-2">
        <img src="{{ $pembeli && $pembeli->pengguna && $pembeli->pengguna->foto_profil
            ? asset('storage/' . $pembeli->pengguna->foto_profil)
            : asset('/images/profile.png') }}"
            class="w-10 h-10 rounded-full" alt="Profile Icon">
        <p class="font-semibold text-lg">
            {{ $pembeli->pengguna->nama ?? Auth::user()->nama ?? 'User' }}
        </p>
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
