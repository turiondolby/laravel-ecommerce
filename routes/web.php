<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartIndexController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CheckoutIndexController;
use App\Http\Controllers\OrderConfirmationIndexController;

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

Route::get('/', HomeController::class)->name('home');

Route::get('cart', CartIndexController::class)->name('cart');

Route::get('checkout', CheckoutIndexController::class);

Route::get('categories/{category:slug}', CategoryShowController::class);

Route::get('products/{product:slug}', ProductShowController::class);

Route::get('orders/{order:uuid}/confirmation', OrderConfirmationIndexController::class)->name('orders.confirmation');

Route::get('orders', function () {
    //
})->name('orders');

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
