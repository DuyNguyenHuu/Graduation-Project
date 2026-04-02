<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
Route::fallback(function () {
    return redirect('/')
        ->withErrors(['msg' => 'The page you are looking for does not exist.']);
});

Route::get('/login', [AccountsController::class,'index']);
Route::post('/login', [AccountsController::class, 'login'])->name('login');
Route::post('/register', [AccountsController::class, 'register'])->name('register');
Route::get('/logout', [AccountsController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/change-password', [AccountsController::class, 'changePasswordForm'])->middleware('auth')->name('password.change.form');
Route::post('/change-password', [AccountsController::class, 'changePassword'])->middleware('auth')->name('password.change.process');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search-product', [ProductsController::class, 'searchAjax'])->name('searchProduct');


Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/{idProduct}', [ProductsController::class, 'detailProduct']);
Route::post('/products/{idProduct}/review', [ProductsController::class, 'submitReview'])->middleware('auth')->name('submitReview');
Route::get('/reviews/filter/{productId}', [ProductsController::class, 'detailProduct']);
Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('/blogs/category={idBCategory}', [BlogsController::class, 'index']);
Route::get('/blogs/{idBlog}', [BlogsController::class, 'detailBlog']);
route::get('/coupons', [CouponsController::class, 'index'])->name('coupons');
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.form');
Route::post('/contacts', [ContactsController::class, 'sendMessage'])->name('contacts.process');
Route::get('/carts',[CartsController::class, 'index'])->name('cart.view');
Route::post('/add-to-cart', [CartsController::class, 'addToCart'])->name('cart.add');
Route::delete('/carts/remove/{key}', [CartsController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/increase/{key}', [CartsController::class, 'increase'])->name('cart.increase');
Route::patch('/cart/decrease/{key}', [CartsController::class, 'decrease'])->name('cart.decrease');
Route::post('/carts/apply-coupon', [CartsController::class, 'applyCoupon'])->name('cart.applyCoupon');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.form')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.process')->middleware('auth');
Route::get('/checkout/invoice', [CheckoutController::class, 'invoice'])->name('checkout.invoice')->middleware('auth');

Route::get('/payment/create', [VNPayController::class, 'createPayment'])->middleware('auth');
Route::get('/payment/return', [VNPayController::class, 'returnPayment'])->middleware('auth');
Route::get('/result', [ResultController::class, 'result'])->middleware('auth')->name('result');

Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth');
Route::get('/orders/{idOrder}', [OrdersController::class, 'detailOrder'])->middleware('auth');
Route::delete('orders/cancel/{idOrder}', [OrdersController::class, 'cancelOrder'])->middleware('auth')->name('orders.cancel');
Route::get('/chat', [ChatController::class, 'index'])->middleware('auth')->name('chat');
Route::post('/chat/ask', [ChatController::class,'askAI'])->middleware('auth');
Route::get('/cache-test', function () {
    try {
        Cache::put('test_key', 'Hello Memcached', 60);
        return Cache::get('test_key');
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

Route::get('/search', function(Request $request){
    $keyword = $request->keyword;
    return DB::table('products')
                ->where('NameProduct', 'like', "%$keyword%")
                ->select('*')
                ->get();
});
Route::get('/product/{id}', function($id){
    return DB::table('products')->where('IdProduct', $id)->first();
});

Route::post('/upload-images', [ContactsController::class, 'upload']);

Route::get('/auth/{provider}', [AccountsController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [AccountsController::class, 'callback']);