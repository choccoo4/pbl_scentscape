<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;

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

Route::get('/product-detail/{slug}', function () {
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

Route::get('/tambahproduk', [ProdukController::class, 'create'])->name('tambahproduk');

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
})->name('laporan');

Route::get('/profil-penjual', function () {
    return view('sellers.profile');
})->name('profil-penjual');

Route::get('/Ubahpasswrod-penjual', function () {
    return view('sellers.change-pw');
})->name('Ubahpasswrod-penjual');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::get('/profile', function () {
    return view('buyer.profile');
})->name('profile');

Route::get('/change-pw', function () {
    return view('buyer.change-pw');
})->name('change-pw');

Route::get('/transaksi', function () {
    return view('buyer.transaksi');
})->name('transaksi');

Route::get('/checkout', function () {
    return view('buyer.chekout');
})->name('chekout');

// routes/web.php
Route::get('/about', function () {
    return view('buyer.about');
})->name('about');

Route::get('/order-history', function () {
    return view('buyer.order-history');
})->name('order.history');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/pengaturan', function () {
    return view('sellers.pengaturan');
})->name('pengaturan.index');

//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
