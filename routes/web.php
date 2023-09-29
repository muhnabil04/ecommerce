<?php

use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('user.gues', [
//         'title' => 'home',
//     ]);
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Auth::routes();




Route::get('/dashboard', [ProdukController::class, 'userIndex']);

Route::get('/produk', [ProdukController::class, 'produk'])->name('produk');


// Route::middleware(['auth', 'cekrole:1'])->group(function () {

//     Route::get('/pesan/{id}', [PesanController::class, 'index'])->name('pesan.index');
//     Route::post('/pesan/{id}', [PesanController::class, 'pesan'])->name('pesan');
// });

// Routes for authenticated users with the 'user' role
Route::middleware(['auth', 'cekrole:1,2'])->group(function () {
    Route::get('/pesan/{id}', [PesanController::class, 'index'])->name('pesan.index');
    Route::post('/pesan/{id}', [PesanController::class, 'pesan'])->name('pesan');
    // Add more user-specific routes here if needed
});


Route::middleware(['auth', 'cekrole:1'])->group(function () {

    Route::get('/admin', [ProdukController::class, 'adminIndex']);
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.index');
    Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('admin.create');
    Route::delete('/admin/produk/destroy/{id}', [ProdukController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/produk/edit/{id}', [ProdukController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/produk/store', [ProdukController::class, 'store'])->name('admin.store');
    Route::put('/admin/produk/edit/{id}', [ProdukController::class, 'update'])->name('admin.update');


    //user
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/edit/{id}', [UserController::class, 'update'])->name('admin.user.update');


    //coupon
    Route::get('/admin/coupon', [CouponController::class, 'index'])->name('admin.coupon.index');
    Route::get('/admin/coupon/create', [CouponController::class, 'create'])->name('admin.coupon.create');
    Route::get('/admin/coupon/edit/{id}', [CouponController::class, 'edit'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/edit/{id}', [CouponController::class, 'update'])->name('admin.coupon.update');
    Route::post('/admin/coupon/store', [CouponController::class, 'store'])->name('admin.coupon.store');
    Route::delete('/admin/coupon/destroy/{id}', [CouponController::class, 'destroy'])->name('admin.coupon.destroy');

    // The following routes might be mistakenly duplicated, remove them from here
    // Route::get('/pesan/{id}', [PesanController::class, 'index'])->name('pesan.index');
    // Route::post('/pesan/{id}', [PesanController::class, 'pesan'])->name('pesan');
    // Remove the duplicated routes from here

    // Add more admin-specific routes here if needed
});




// Route::get('check_out', [PesanController::class, 'check_out']);
Route::get('check-out', [PesanController::class, 'check_out']);
Route::get('check-out/{id}', [PesanController::class, 'delete']);

Route::post('konfirmasi-checkout', [PesanController::class, 'konfirmasi']);

Route::get('/', [ProdukController::class, 'gues']);

Route::get('/produk/search', [ProdukController::class, 'produk']);

Route::get('/riwayat', [PesanController::class, 'riwayat'])->name('riwayat');

Route::get('riwayat/export/excel', [PesanController::class, 'downloadRiwayatExcel'])->name('excel');
