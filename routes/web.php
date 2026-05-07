<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
    
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products/store', [AdminController::class, 'productStore'])->name('admin.products.store');
    
    // Banners
    Route::get('/banners', [AdminController::class, 'banners'])->name('admin.banners');
    Route::post('/banners/store', [AdminController::class, 'bannerStore'])->name('admin.banners.store');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    
    // Queries
    Route::get('/queries', [AdminController::class, 'queries'])->name('admin.queries');
    Route::post('/queries/update-status/{id}', [AdminController::class, 'updateQueryStatus'])->name('admin.queries.update-status');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/track-order', [PageController::class, 'trackOrder'])->name('track-order');
Route::get('/collections/{slug}', [PageController::class, 'collection'])->name('collection.show');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Flow
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/payment', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/order/place', [\App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('order.place');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
