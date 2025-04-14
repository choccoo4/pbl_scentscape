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

Route::get('/best-sellers', function () {
    return view('best-sellers');
});

Route::get('/gifts', function () {
    return view('gifts');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});
