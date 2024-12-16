<?php

use Illuminate\Support\Facades\Route;

// User Controller

// Auth Controller
use App\Http\Controllers\UserController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\RatingsController;

// Admin Controller
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\TransactionController;


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

Route::get('/', [UserController::class, 'landingPage'])->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('post.register');

    // Route untuk menampilkan form login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [AuthController::class, 'showHome'])->name(name: 'home.show');

    Route::get('/search', [UserController::class, 'searchMenu'])->name(name: 'menu.search');
    Route::post('/menu/clear-history', [UserController::class, 'clearSearchHistory'])->name('menu.clearHistory');

    Route::get('/menus', [MenuController::class, 'showCategoriesPage'])->name('menus.index');
    Route::get('/menu/{id}', [MenuController::class, 'showDetailmenu'])->name('menu.show');

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');

    Route::get('/cart', [CartController::class, 'showCartPage'])->name('cart.index');
    Route::delete('/cart/destroy/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/add/{menuId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/transactions/{id}', [TransactionController::class, 'showTransaction'])->name('transactions.show');
    Route::get('/order/{id}', [TransactionController::class, 'showOrderPage'])->name('order.show');

    Route::post('/saldo/top-up', [UserController::class, 'processTopUp'])->name('saldo.topup.process');

    Route::post('/wishlist/{menuId}/add', [WishlistController::class, 'addWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
    Route::post('/wishlist/{menuId}/remove', [WishlistController::class, 'removeWishlist'])->name('wishlist.remove');

    Route::post('/menu/{menuId}/rate', [RatingsController::class, 'addRatings'])->name('menu.rate');

    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/purchase/{packageId}', [PremiumController::class, 'purchase'])->name('premium.purchase');
});

// Routes untuk dashboard admin
Route::middleware(['auth','isAdmin'])->group(function () {
    Route::get('/dashboard', [MenuController::class, 'dashboardAdmin'])->name('admin.dashboard');

    Route::get('/admin/menus/create', [MenuController::class, 'showCreateMenu'])->name('admin.menus.create');
    Route::get('/admin/menus/{id}/edit', [MenuController::class, 'showEditMenu'])->name('admin.menus.edit');
    Route::delete('/admin/menus/{id}', [MenuController::class, 'destroyMenu'])->name('admin.menus.destroy');
    Route::post('/admin/menus', [MenuController::class, 'addMenu'])->name('admin.menus.store');
    Route::put('/admin/menus/{id}', [MenuController::class, 'updateMenu'])->name('admin.menus.update');

    Route::post('/admin/vouchers', [VoucherController::class, 'addVouchers'])->name('admin.vouchers.store');
    Route::delete('/admin/vouchers/{id}', [VoucherController::class, 'removeVoucher'])->name('admin.vouchers.destroy');

    Route::post('/category/submit', [CategoryController::class, 'addCategories'])->name('category.submit');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroyCategories'])->name('category.destroy');

    Route::post('/todo', [TodoController::class, 'addTodo'])->name('todo.submit');
    Route::delete('/todo/{id}', [TodoController::class, 'destroyTodo'])->name('todo.destroy');
    Route::patch('/todos/{id}/complete', [TodoController::class, 'markAsCompleted'])->name('todos.complete');

    Route::get('/track', [TrackController::class, 'showTrack'])->name('admin.track');

    Route::get('/menu/admin/create', [ProfileController::class, 'showYourMenu'])->name('yourMenu.show');
    Route::get('/your_order', [ProfileController::class, 'showYourOrder'])->name('yourOrder.show');
});

