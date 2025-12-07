<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Models\Chat; // [PENTING] Import Model Chat untuk Notifikasi

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Public (Tamu/User)
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/product/{id}', [CatalogController::class, 'show'])->name('product.show');
Route::get('/dashboard', [CatalogController::class, 'index'])->name('dashboard'); // User Dashboard = Home
Route::get('/search-suggestions', [CatalogController::class, 'getSuggestions'])->name('search.suggestions');
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');

// Group Middleware Auth (Wajib Login)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout & Beli
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('buy.now');

    // Pembayaran & Order
    Route::get('/payment/{id}', [OrderController::class, 'paymentSimulation'])->name('payment.simulation');
    Route::post('/payment/{id}', [OrderController::class, 'paymentSuccess'])->name('payment.success');
    Route::patch('/payment/{id}/change', [OrderController::class, 'updatePaymentMethod'])->name('payment.change');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');

    // Review & Chat User
    Route::post('/product/{id}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.get');
    Route::post('/chat/read', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('chat.read');
});

// Route ADMIN (Wajib Login & Role Admin)
Route::middleware(['auth', 'admin'])->group(function () {

    // [UPDATED] Dashboard Admin dengan Data Notifikasi Chat
    Route::get('/admin/dashboard', function () {
        // Hitung pesan yang belum dibaca (unread) dari user
        $unreadChats = Chat::where('is_admin', false)
            ->where('is_read', false)
            ->count();

        return view('admin.dashboard', compact('unreadChats'));
    })->name('admin.dashboard');

    // Manajemen Produk
    Route::resource('admin/products', ProductController::class)->names('admin.products');

    // Manajemen Transaksi (Orders)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{id}/approve', [AdminOrderController::class, 'markAsPaid'])->name('admin.orders.approve');
    Route::delete('/admin/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Manajemen User
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Manajemen Review
    Route::get('/admin/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::post('/admin/reviews/{id}/reply', [App\Http\Controllers\Admin\ReviewController::class, 'reply'])->name('admin.reviews.reply');
    Route::delete('/admin/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Manajemen About Us
    Route::get('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    // Manajemen Chat (Live Support)
    Route::get('/admin/chat', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/admin/chat/{userId}', [App\Http\Controllers\Admin\ChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/admin/chat/{userId}', [App\Http\Controllers\Admin\ChatController::class, 'reply'])->name('admin.chat.reply');

    // Manajemen Kategori
    Route::get('/admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/admin/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

require __DIR__ . '/auth.php';
