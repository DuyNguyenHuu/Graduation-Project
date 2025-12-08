<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ShippingController;
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

    // Authentication Routes...
    Route::get('/login', [UserController::class, 'loginPage'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('loginProcess');

    // Dashboard Route...

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashBoard', [DashBoardController::class, 'index'])->name('dashBoard');
        Route::get('/', [DashBoardController::class, 'index'])->name('dashBoard');
        Route::resource('/categories', CategoryController::class);
        Route::resource('/subcategories', SubCategoryController::class);

        Route::resource('/bcategories', BCategoryController::class);
        Route::resource('/blogs', BlogController::class);

        Route::resource('/productList', ProductListController::class);
        Route::get('/productList/{productList}/attributes',[ProductListController::class, 'attribute'])->name('productList.attribute');
        Route::get('/productList/{productList}/attributes/create', [ProductListController::class, 'createAttribute'])->name('productList.createAttribute');
        Route::post('/productList/{productList}/attributes', [ProductListController::class, 'storeAttribute'])->name('productList.storeAttribute');
        Route::get('/productList/{productList}/attributes/{idOption}/edit',[ProductListController::class,'editAttribute'])->name('productList.editAttribute');
        Route::put('/productList/{productList}/attributes/{idOption}',[ProductListController::class,'updateAttribute'])->name('productList.updateAttribute');
        Route::delete('/productList/{productList}/attributes/{idOption}',[ProductListController::class,'destroyAttribute'])->name('productList.destroyAttribute');

        Route::resource('/productReviews', ProductReviewController::class);

        Route::resource('/coupons', CouponController::class);
        Route::resource('shippings', ShippingController::class);

        Route::resource('/users', UserController::class);

        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    });
    