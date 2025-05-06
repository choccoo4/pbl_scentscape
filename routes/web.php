<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Buyer\AboutController;
use App\Http\Controllers\Buyer\BestSellersController;
use App\Http\Controllers\Buyer\ChangePwController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\GiftsController;
use App\Http\Controllers\Buyer\HomeController;
use App\Http\Controllers\Buyer\OrderHistoryController;
use App\Http\Controllers\Buyer\ProductDetailController;
use App\Http\Controllers\Buyer\ProfileController;
use App\Http\Controllers\Buyer\ShopController;
use App\Http\Controllers\Buyer\TransaksiController;
use App\Http\Controllers\Buyer\CartController;

use App\Http\Controllers\Seller\ProdukController;


Route::get('/tambahproduk', [ProdukController::class, 'create'])->name('tambahproduk');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/best-sellers', [BestSellersController::class, 'bestSellers'])->name('best-sellers');
Route::get('/gifts', [GiftsController::class, 'gifts'])->name('gifts');
Route::get('/product-detail/{slug}', [ProductDetailController::class, 'productDetail'])->name('product-detail');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::get('/change-pw', [ChangePwController::class, 'changePw'])->name('change-pw');
Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/order-history', [OrderHistoryController::class, 'orderHistory'])->name('order.history');

//Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
//Route::get('/daftarproduk', [SellerController::class, 'daftarProduk'])->name('produk.index');
//Route::get('/tambahproduk', [SellerController::class, 'tambahProduk'])->name('tambahproduk');
//Route::get('/updateproduk', [SellerController::class, 'updateProduk'])->name('updateproduk');
//Route::get('/daftarpesanan', [SellerController::class, 'daftarPesanan'])->name('pesanan.index');
//Route::get('/rekapitulasi', [SellerController::class, 'rekapitulasi'])->name('rekap.index');
//Route::get('/laporan', [SellerController::class, 'laporan'])->name('laporan');
//Route::get('/profil-penjual', [SellerController::class, 'profilPenjual'])->name('profil-penjual');
//Route::get('/Ubahpasswrod-penjual', [SellerController::class, 'ubahPasswordPenjual'])->name('Ubahpasswrod-penjual');
//Route::get('/pengaturan', [SellerController::class, 'pengaturan'])->name('pengaturan.index');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');