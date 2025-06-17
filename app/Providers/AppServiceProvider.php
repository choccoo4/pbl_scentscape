<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.navbar', function ($view) {
            $user = Auth::user();

            $notifCount = 0;
            if ($user) {
                // Hitung jumlah pesanan yang butuh perhatian
                // Contoh: status 'Menunggu Verifikasi' dan 'Dikemas'
                $notifCount = Pesanan::whereIn('status', ['Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Terkirim'])->count();
            }

            $view->with([
                'authUser' => $user,
                'notifCount' => $notifCount,
            ]);
        });
    }
}
