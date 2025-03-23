<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
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
use App\Http\Controllers\ArticleImageController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {

    //dashboard
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //khách hàng
    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/users/toggle-on', [UserController::class, 'toggleOn'])->name('users.toggleOn');
    Route::post('/users/toggle-off', [UserController::class, 'toggleOff'])->name('users.toggleOff');

    //sản phẩm
    Route::resource('products', ProductController::class)->parameters([
        'products' => 'product:slug'
    ]);
    Route::patch('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
    Route::patch('/products/{id}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');
    Route::patch('/products/{id}/toggle-best-selling', [ProductController::class, 'toggleBestSelling'])->name('products.toggleBestSelling');
    Route::post('/products/toggle-on', [ProductController::class, 'toggleOn'])->name('products.toggleOn');
    Route::post('/products/toggle-off', [ProductController::class, 'toggleOff'])->name('products.toggleOff');

    //hình sản phẩm
    Route::resource('productImages', ProductImageController::class);
    Route::patch('productImages/{id}/is-primary', [ProductImageController::class, 'isPrimary'])->name('productImages.isPrimary');

    //quyền
    Route::resource('roles', RoleController::class);
    Route::patch('/roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggleStatus');

    //danh mục sản phẩm
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

    //danh mục bài viết
    Route::resource('articleCategories', ArticleCategoryController::class);
    Route::patch('/articleCategories/{id}/toggle-status', [ArticleCategoryController::class, 'toggleStatus'])->name('articleCategories.toggleStatus');
    Route::post('/articleCategories/toggle-on', [ArticleCategoryController::class, 'toggleOn'])->name('articleCategories.toggleOn');
    Route::post('/articleCategories/toggle-off', [ArticleCategoryController::class, 'toggleOff'])->name('articleCategories.toggleOff');
    Route::post('/categories/{id}/update-position', [ArticleCategoryController::class, 'updatePosition'])
        ->name('articleCategories.updatePosition');

    //Bài viết
    Route::resource('articles', ArticleController::class);
    Route::patch('/articles/{id}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('articles.toggleStatus');
    Route::post('/articles/toggle-on', [ArticleController::class, 'toggleOn'])->name('articles.toggleOn');
    Route::post('/articles/toggle-off', [ArticleController::class, 'toggleOff'])->name('articles.toggleOff');

    //Khuyến mãi
    Route::resource('discounts', DiscountController::class);
    Route::post('/discounts/toggle-on', [DiscountController::class, 'toggleOn'])->name('discounts.toggleOn');
    Route::post('/discounts/toggle-off', [DiscountController::class, 'toggleOff'])->name('discounts.toggleOff');
    Route::post('/discounts/update-status', [DiscountController::class, 'updateStatus'])->name('discounts.updateStatus');
    Route::patch('/discounts/{id}/toggle-status-off', [DiscountController::class, 'toggleOff'])->name('discounts.toggleOff');
    Route::patch('/discounts/{id}/toggle-status-on', [DiscountController::class, 'toggleOn'])->name('discounts.toggleOn');
    Route::post('/discounts/toggle-bulk-on', [DiscountController::class, 'toggleBulkOn'])->name('discounts.toggleBulkOn');
    Route::post('/discounts/toggle-bulk-off', [DiscountController::class, 'toggleBulkOff'])->name('discounts.toggleBulkOff');

    //Đơn hàng
    Route::resource('orders', OrderController::class);
});
