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
use App\Http\Controllers\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

// Wishlist
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
    Route::post('/categories/update/{id}', [AdminController::class, 'categoryUpdate'])->name('admin.categories.update');
    Route::post('/categories/delete/{id}', [AdminController::class, 'categoryDelete'])->name('admin.categories.delete');
    
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products/store', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::post('/products/update/{id}', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::post('/products/delete/{id}', [AdminController::class, 'productDelete'])->name('admin.products.delete');
    
    // Banners
    Route::get('/banners', [AdminController::class, 'banners'])->name('admin.banners');
    Route::post('/banners/store', [AdminController::class, 'bannerStore'])->name('admin.banners.store');
    Route::post('/banners/update/{id}', [AdminController::class, 'bannerUpdate'])->name('admin.banners.update');
    Route::post('/banners/delete/{id}', [AdminController::class, 'bannerDelete'])->name('admin.banners.delete');
    
    // Testimonials
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('admin.testimonials');
    Route::post('/testimonials/store', [AdminController::class, 'testimonialStore'])->name('admin.testimonials.store');
    Route::post('/testimonials/update/{id}', [AdminController::class, 'testimonialUpdate'])->name('admin.testimonials.update');
    Route::post('/testimonials/delete/{id}', [AdminController::class, 'testimonialDelete'])->name('admin.testimonials.delete');
    
    // FAQs
    Route::get('/faqs', [AdminController::class, 'faqs'])->name('admin.faqs');
    Route::post('/faqs/store', [AdminController::class, 'faqStore'])->name('admin.faqs.store');
    Route::post('/faqs/update/{id}', [AdminController::class, 'faqUpdate'])->name('admin.faqs.update');
    Route::post('/faqs/delete/{id}', [AdminController::class, 'faqDelete'])->name('admin.faqs.delete');
    
    // Coupons
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::post('/coupons/store', [AdminController::class, 'couponStore'])->name('admin.coupons.store');
    Route::post('/coupons/update/{id}', [AdminController::class, 'couponUpdate'])->name('admin.coupons.update');
    Route::post('/coupons/delete/{id}', [AdminController::class, 'couponDelete'])->name('admin.coupons.delete');
    
    // Subscribers
    Route::get('/subscribers', [AdminController::class, 'subscribers'])->name('admin.subscribers');
    Route::post('/subscribers/delete/{id}', [AdminController::class, 'subscriberDelete'])->name('admin.subscribers.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    
    // Attributes
    Route::get('/attributes', [AdminController::class, 'attributes'])->name('admin.attributes');
    Route::post('/attributes/store', [AdminController::class, 'attributeStore'])->name('admin.attributes.store');
    Route::post('/attributes/values/store', [AdminController::class, 'attributeValueStore'])->name('admin.attributes.values.store');
    
    // Queries
    Route::get('/queries', [AdminController::class, 'queries'])->name('admin.queries');
    Route::post('/queries/update-status/{id}', [AdminController::class, 'updateQueryStatus'])->name('admin.queries.update-status');
    Route::post('/queries/delete/{id}', [AdminController::class, 'queryDelete'])->name('admin.queries.delete');

    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::post('/customers/delete/{id}', [AdminController::class, 'customerDelete'])->name('admin.customers.delete');

    // Reviews
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::post('/reviews/delete/{id}', [AdminController::class, 'reviewDelete'])->name('admin.reviews.delete');
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
    Route::post('/checkout/apply-coupon', [\App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/checkout/remove-coupon', [\App\Http\Controllers\CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    Route::post('/checkout/payment', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/order/place', [\App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('order.place');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
