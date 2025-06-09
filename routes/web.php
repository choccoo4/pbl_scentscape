<?php

use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\ProdukController as ControllersProdukController;
use App\Http\Controllers\RekapitulasiController as ControllersRekapitulasiController;
use App\Http\Controllers\seller\ProdukController;
use App\Http\Controllers\seller\ProfilController;
use App\Http\Controllers\seller\RekapitulasiController;
use App\Http\Controllers\seller\LaporanController;
use App\Http\Controllers\seller\AromaController;
use App\Http\Controllers\seller\UbahpwController;
use App\Http\Controllers\seller\DashboardController;
use App\Http\Controllers\seller\DaftarpesananController;

Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
    Route::get('/best-sellers', [BestSellersController::class, 'bestSellers'])->name('best-sellers');
    Route::get('/gifts', [GiftsController::class, 'gifts'])->name('gifts');
    Route::get('/produk/{id}', [ProductDetailController::class, 'productDetail'])->name('produk.show');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/change-pw', [ChangePwController::class, 'changePw'])->name('change-pw');
    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/order-history', [OrderHistoryController::class, 'orderHistory'])->name('order.history');
});

Route::middleware(['auth', 'role:penjual'])->prefix('seller')->group(function () {
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create'); // Tampil form tambah produk
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');        // Proses simpan produk
    Route::post('/aroma/store', [AromaController::class, 'store'])->name('aroma.store');
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekap.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/profil-penjual', [ProfilController::class, 'index'])->name('profil-penjual');
    Route::get('/ubahpassword', [UbahpwController::class, 'ubahpw'])->name('ubahpw');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/daftarproduk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/daftarpesanan', [DaftarpesananController::class, 'daftarpesanan'])->name('pesanan.index');
    Route::delete('/produk/{no_produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('{no_produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('{no_produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::get('/rekapitulasi/pdf', [RekapitulasiController::class, 'exportPdf'])->name('rekap.pdf');
    Route::get('/rekapitulasi/excel', [RekapitulasiController::class, 'exportExcel'])->name('rekap.excel');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register']);
