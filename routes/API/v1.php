<?php

use App\Http\Controllers\API\ArticleCategoryController;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DiscountController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductAttributeController;
use App\Http\Controllers\API\ProductFavoriteController;
use App\Http\Controllers\API\ProductImageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    //người dùng
    Route::post('login', [AuthAPIController::class, 'login']);
    Route::post('register', [AuthAPIController::class, 'register']);

    //banner
    Route::get('/banners', [BannerController::class, 'getAll']);

    //danh mục sản phẩm
    Route::get('/categories', [CategoryController::class, 'getAll']);
    Route::get('/categories/parents', [CategoryController::class, 'getParentCategories']);
    Route::get('/categories/{parent_id}/children', [CategoryController::class, 'getChildCategories']);

    //sản phẩm
    Route::get('/products', [ProductController::class, 'getAll']);
    Route::get('/products/{id}', [ProductController::class, 'getById']);

    //hình ảnh sản phẩm
    Route::get('/products/{product_id}/avatar', [ProductImageController::class, 'getAvatar']);
    Route::get('/products/{product_id}/images', [ProductImageController::class, 'getAll']);

    //thuộc tính sản phẩm
    Route::get('/products/{product_id}/attributes', [ProductAttributeController::class, 'getAttributesByProduct']);
    Route::get('/products/attributes', [ProductAttributeController::class, 'getAllGroupedAttributes']);

    //danh mục bài viết
    Route::get('/articleCategories', [ArticleCategoryController::class, 'getAll']);

    //bài viết
    Route::get('/articles', [ArticleCategoryController::class, 'getAll']);
    Route::get('/articles/{id}', [ArticleCategoryController::class, 'getById']);

    //đặt hàng
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::post('/cancelOrder/{id}', [OrderController::class, 'cancelOrder']);

    //payment
    Route::post('/payments', [PaymentController::class, 'createPayment']);
    Route::post('/payments/{id}', [PaymentController::class, 'createPayment']);

    Route::middleware('auth:sanctum')->group(function () {
        //người dùng
        Route::get('/user', [UserAPIController::class, 'show']);
        Route::put('/user/{id}', [UserAPIController::class, 'update']);
        Route::post('/logout', [AuthAPIController::class, 'logout']);

        //sản phẩm yêu thích
        Route::get('/getUserFavorites', [ProductFavoriteController::class, 'getUserFavorites']);
        Route::post('/addToFavorites', [ProductFavoriteController::class, 'addToFavorites']);
        Route::post('/removeFromFavorites', [ProductFavoriteController::class, 'removeFromFavorites']);
        Route::post('/isFavorite', [ProductFavoriteController::class, 'isFavorite']);

        //giảm giá
        Route::post('/discounts/check', [DiscountController::class, 'check']);
        Route::get('/discounts', [DiscountController::class, 'getAllDiscounts']);
        Route::get('/discounts/{id}', [DiscountController::class, 'getDiscountById']);

        //đơn hàng
        Route::get('/orders', [OrderController::class, 'getOrderByIp']);

        //Đánh giá sản phẩm
        Route::prefix('reviews')->group(function () {
            Route::get('/product/{product_id}', [ProductReviewController::class, 'getReviewsByProduct']);
            Route::post('/create', [ProductReviewController::class, 'createReview']);
            Route::put('/update/{id}', [ProductReviewController::class, 'updateReview']);
            Route::delete('/delete/{id}', [ProductReviewController::class, 'deleteReview']);
        });
    });
});
