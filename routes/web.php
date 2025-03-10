<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');


    Route::resource('products', ProductController::class)->parameters([
        'products' => 'product:slug'
    ]);
    Route::patch('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
    Route::patch('/products/{id}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');
    Route::patch('/products/{id}/toggle-best-selling', [ProductController::class, 'toggleBestSelling'])->name('products.toggleBestSelling');
    Route::post('/products/toggle-on', [ProductController::class, 'toggleOn'])->name('products.toggleOn');
    Route::post('/products/toggle-off', [ProductController::class, 'toggleOff'])->name('products.toggleOff');
    // Route::post('/products/bulk-feature', [ProductController::class, 'bulkFeature'])->name('products.bulkFeature');
    // Route::post('/products/bulk-best-selling', [ProductController::class, 'bulkBestSelling'])->name('products.bulkBestSelling');
    // Route::post('/products/bulk-status', [ProductController::class, 'bulkStatus'])->name('products.bulkStatus');


    Route::resource('productImages', ProductImageController::class);
    Route::patch('productImages/{id}/is-primary', [ProductImageController::class, 'isPrimary'])->name('productImages.isPrimary');


    Route::resource('roles', RoleController::class);
    Route::patch('/roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggleStatus');


    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category:slug'
    ]);
    Route::patch('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');

    //đánh giá sản phẩm
    Route::prefix('reviews')->group(function () {
        Route::get('/product/{product_id}', [ProductReviewController::class, 'getReviewsByProduct']);
        Route::post('/create', [ProductReviewController::class, 'createReview']);
        Route::put('/update/{id}', [ProductReviewController::class, 'updateReview']);
        Route::delete('/delete/{id}', [ProductReviewController::class, 'deleteReview']);

        // Route dành cho admin
        Route::post('/approve/{id}', [ProductReviewController::class, 'approveReview']);
        Route::post('/reject/{id}', [ProductReviewController::class, 'rejectReview']);
    });
});
