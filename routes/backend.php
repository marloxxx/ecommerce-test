<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\ReviewController;

Route::name('backend.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/file-manager', function () {
        return view('layouts.backend.file-manager');
    })->name('file-manager');

    // user route
    Route::resource('users', UserController::class);
    // Banner
    Route::resource('banner', BannerController::class);
    // Brand
    Route::resource('brand', BrandController::class);
    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', CategoryController::class);
    // Product
    Route::resource('/product', ProductController::class);
    // Ajax for sub category
    Route::post('/category/{id}/child', [CategoryController::class, 'getChildByParentId'])->name('category.child');

    // Order
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/order/income', [OrderController::class, 'incomeChart'])->name('order.income');
    Route::get('/order/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    // Coupon
    Route::resource('/coupon', CouponController::class);

    // Review
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');

    // Settings
    Route::get('settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('setting/update', [DashboardController::class, 'settingsUpdate'])->name('settings.update');

    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('notification.show');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
    // Password Change
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [DashboardController::class, 'changPasswordStore'])->name('change.password');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    // Logout
    Route::get('/logout', [AuthController::class, 'do_logout'])->name('logout');
});
