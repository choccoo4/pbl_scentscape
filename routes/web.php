<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\seller\ProdukController;
use App\Http\Controllers\seller\ProfilController;
use App\Http\Controllers\seller\RekapitulasiController;
use App\Http\Controllers\seller\LaporanController;
use App\Http\Controllers\seller\AromaController;
use App\Http\Controllers\seller\UbahpwController;
use App\Http\Controllers\seller\DashboardController;
use App\Http\Controllers\seller\DaftarpesananController;

// Routes untuk pembeli dengan middleware role:pembeli
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{no_produk}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{no_produk}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{no_produk}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Halaman utama dan toko
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
    Route::get('/best-sellers', [BestSellersController::class, 'bestSellers'])->name('best-sellers');
    Route::get('/gifts', [GiftsController::class, 'gifts'])->name('gifts');

    // Detail produk
    Route::get('/produk/{id}', [ProductDetailController::class, 'productDetail'])->name('produk.show');

    // Profil dan pengaturan akun
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-pw', [ChangePwController::class, 'changePw'])->name('change-pw');
    Route::post('/change-pw', [ChangePwController::class, 'updatePassword'])->name('change-pw.update');

    // Transaksi dan checkout
    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    // Halaman informasi
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/order-history', [OrderHistoryController::class, 'orderHistory'])->name('order.history');
});

// Routes untuk penjual dengan prefix seller dan middleware role:penjual
Route::middleware(['auth', 'role:penjual'])->prefix('seller')->group(function () {
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::post('/aroma/store', [AromaController::class, 'store'])->name('aroma.store');
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekap.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/profil-penjual', [ProfilController::class, 'index'])->name('profil-penjual');
    Route::put('/profil-penjual', [ProfilController::class, 'update'])->name('profil-penjual.update');

    // Change Password Penjual
    Route::get('/ubahpassword', [UbahpwController::class, 'ubahpw'])->name('ubahpw');
    Route::post('/ubahpassword', [UbahpwController::class, 'updatePassword'])->name('ubahpw.update');

    // Dashboard dan manajemen produk/pesanan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/daftarproduk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/daftarpesanan', [DaftarpesananController::class, 'daftarpesanan'])->name('pesanan.index');
    Route::delete('/produk/{no_produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('{no_produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('{no_produk}', [ProdukController::class, 'update'])->name('produk.update');

    // Export rekapitulasi
    Route::get('/rekapitulasi/pdf', [RekapitulasiController::class, 'exportPdf'])->name('rekap.pdf');
    Route::get('/rekapitulasi/excel', [RekapitulasiController::class, 'exportExcel'])->name('rekap.excel');
});

// Routes untuk autentikasi umum
Route::middleware('guest.redirect')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register']);



Route::get('/detailpesanan', function () {
    return view('sellers.detailpesanan');
});
