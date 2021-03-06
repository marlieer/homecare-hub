<?php

use App\Http\Controllers\AddToCart;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group( function () {
    Route::resource('product', ProductController::class);
    Route::resource('transaction', TransactionController::class);
});


require __DIR__.'/auth.php';
