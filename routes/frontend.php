<?php

use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\MessageController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\OrderController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
// login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'do_login'])->name('do_login');

// register
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'do_register'])->name('do_register');

// Frontend Routes
Route::get('/home', [FrontendController::class, 'index']);
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product.detail');
Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');
Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');
Route::get('/product-brand/{slug}', [FrontendController::class, 'productBrand'])->name('product-brand');
Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
Route::get('/product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
Route::match(['get', 'post'], '/filter', [FrontendController::class, 'productFilter'])->name('shop.filter');

// Cart
Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
Route::post('cart/increase', [CartController::class, 'increase'])->name('cart.increase');
Route::post('cart/delete', [CartController::class, 'destroy'])->name('cart.delete');

// Wishlist
Route::post('wishlist/store', [CartController::class, 'wishlistStore'])->name('wishlist.store');
Route::get('wishlist', [CartController::class, 'wishlist'])->name('wishlist');
Route::post('wishlist/delete', [CartController::class, 'wishlistDestroy'])->name('wishlist.delete');

// Checkout
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('coupon/check', [CartController::class, 'couponCheck'])->name('coupon.check');
Route::post('checkout/store', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/order/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

// review
Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

// Logout
Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');

Route::post('callback', [OrderController::class, 'callback'])->name('transaction.callback');
