<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category:slug'
    ]);
});


// các route không có sẽ hiện trang 404
Route::fallback(function () {
    Log::info("Fallback route hit. Request details:", request()->all());
    return view('404');
});
