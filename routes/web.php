<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::get('/shop', function () {
    return view('pages.shop');
})->name('shop');

Route::get('/best-sellers', function () {
    return view('pages.best-sellers');
})->name('best-sellers');

Route::get('/gifts', function () {
    return view('pages.gifts');
})->name('gifts');

Route::get('/product-detail', function () {
    return view('pages.product-detail');
})->name('product-detail');