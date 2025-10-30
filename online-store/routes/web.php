<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\AccountsController;

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

Route::get('/login', [AccountsController::class,'index']);
Route::post('/login', [AccountsController::class, 'login'])->name('login');
Route::post('/register', [AccountsController::class, 'register'])->name('register');
Route::get('/logout', [AccountsController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/{idProduct}', [ProductsController::class, 'detailProduct']);
Route::post('/products/{idProduct}/review', [ProductsController::class, 'submitReview'])->middleware('auth')->name('submitReview');
Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('/blogs/category={idBCategory}', [BlogsController::class, 'index']);
Route::get('/blogs/{idBlog}', [BlogsController::class, 'detailBlog']);
// route::get('/productList/{productList}/attributes',[ProductListController::class, 'attribute'])->name('productList.attribute');