<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.navbar', function ($view) {
            $user = Auth::user();

            $notifCount = 0;
            if ($user) {
                // Hitung jumlah pesanan yang butuh perhatian
                $notifCount = Pesanan::whereIn('status', ["Menunggu Pembayaran", 'Menunggu Verifikasi', 'Dikemas', 'Dikirim', 'Terkirim'])->count();
            }

            $view->with([
                'authUser' => $user,
                'notifCount' => $notifCount,
            ]);
        });

        //if (app()->environment('local')) {
        //    URL::forceScheme('https');
        //}
    }
}
