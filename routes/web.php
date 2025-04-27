<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/best-sellers', function () {
    return view('best-sellers');
});

Route::get('/gifts', function () {
    return view('gifts');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/', function () {
    return view('welcome');
});
 
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/daftarproduk', function () {
    return view('daftarproduk');
})->name('produk.index');

Route::get('/tambahproduk', function () {
    return view('tambahproduk');
})->name('tambahproduk');

Route::get('/updateproduk', function () {
    return view('updateproduk');
})->name('updateproduk');

Route::get('/daftarpesanan', function () {
    return view('daftarpesanan');
})->name('pesanan.index');

Route::get('/rekapitulasi', function () {
    return view('rekapitulasi');
})->name('rekap.index');


Route::get('/laporan', function () {
    return view('laporan');
});

Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan.index');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


