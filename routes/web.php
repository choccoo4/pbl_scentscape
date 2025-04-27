<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('buyer.home');
})->name('home');

Route::get('/shop', function () {
    return view('buyer.shop');
})->name('shop');

Route::get('/best-sellers', function () {
    return view('buyer.best-sellers');
})->name('best-sellers');

Route::get('/gifts', function () {
    return view('buyer.gifts');
})->name('gifts');

Route::get('/product-detail', function () {
    return view('buyer.product-detail');
})->name('product-detail');

Route::get('/', function () {
    return view('welcome');
});
 
Route::get('/dashboard', function () {
    return view('sellers.dashboard');
})->name('dashboard');

Route::get('/daftarproduk', function () {
    return view('sellers.daftarproduk');
})->name('produk.index');

Route::get('/tambahproduk', function () {
    return view('sellers.tambahproduk');
})->name('tambahproduk');

Route::get('/updateproduk', function () {
    return view('sellers.updateproduk');
})->name('updateproduk');

Route::get('/daftarpesanan', function () {
    return view('sellers.daftarpesanan');
})->name('pesanan.index');

Route::get('/rekapitulasi', function () {
    return view('sellers.rekapitulasi');
})->name('rekap.index');


Route::get('/laporan', function () {
    return view('sellers.laporan');
});

Route::get('/pengaturan', function () {
    return view('sellers.pengaturan');
})->name('pengaturan.index');

//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

