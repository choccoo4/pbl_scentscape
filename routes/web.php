<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/transaksi', function () {
    return view('transaksi');
})->name('transaksi');

Route::get('/checkout', function () {
    return view('chekout');
});

// routes/web.php
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/about', function () {
    return view('about');
});

Route::get('/order-history', function () {
    return view('order-history');
})->name('order.history');


Route::get('/cart', function () {
    return view('cart');
});
