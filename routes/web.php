<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogCommentController as AdminBlogCommentController;
use App\Http\Controllers\Admin\BlogDashboardController as AdminBlogDashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Blog\CategoryController as BlogCategoryController;
use App\Http\Controllers\Blog\TagController as BlogTagController;
use App\Http\Controllers\Blog\AuthorController as BlogAuthorController;
use App\Http\Controllers\Blog\CommentController as BlogCommentController;
use App\Http\Controllers\Blog\NewsletterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// FedaPay Webhook (no auth required)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Blog Public Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/author/{id}', [BlogAuthorController::class, 'show'])->name('author');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Blog Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Blog Comments (auth required)
Route::post('/blog/comments', [BlogCommentController::class, 'store'])->name('blog.comments.store')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard Route - Redirection intelligente selon le rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('client.dashboard');
    })->name('dashboard');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Payment Routes
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/{order}/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{order}/failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/{order}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Client Dashboard Routes
    Route::prefix('client')->name('client.')->middleware('customer')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::get('/orders', [ClientOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [ClientOrderController::class, 'show'])->name('orders.show');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // Admin Dashboard Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Brands
        Route::resource('brands', AdminBrandController::class);

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::put('orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');

        // Blog Management
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/dashboard', [AdminBlogDashboardController::class, 'index'])->name('dashboard');

            // Posts
            Route::resource('posts', AdminBlogPostController::class);

            // Categories
            Route::resource('categories', AdminBlogCategoryController::class);

            // Comments
            Route::get('/comments', [AdminBlogCommentController::class, 'index'])->name('comments.index');
            Route::patch('/comments/{id}/approve', [AdminBlogCommentController::class, 'approve'])->name('comments.approve');
            Route::patch('/comments/{id}/reject', [AdminBlogCommentController::class, 'reject'])->name('comments.reject');
            Route::delete('/comments/{id}', [AdminBlogCommentController::class, 'destroy'])->name('comments.destroy');
        });
    });
});

require __DIR__ . '/auth.php';
