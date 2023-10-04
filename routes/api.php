<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\TryCatch;

use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/coupons/create', [CouponController::class, 'store']);

Route::get('produk', [ApiController::class, 'produk']);





Route::middleware('auth:api')->group(function () {
    Route::post('pesan/produk/{id}', [ApiController::class, 'pesan']);
    Route::post('checkout/produk/', [ApiController::class, 'konfirmasi']);
    Route::get('keranjang', [ApiController::class, 'keranjang']);
    Route::get('profile', [ApiController::class, 'profile']);
    Route::get('user/{id}', [ApiController::class, 'getUser']);
});
// Route::group(['middleware' => 'auth:api'], function () {
//     Route::post('/login/akun', [authController::class, 'login']);
// });

Route::post('login', [AuthController::class, 'login']);
