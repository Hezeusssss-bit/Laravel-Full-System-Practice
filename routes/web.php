<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

Route::get('/admin/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    if (!auth()->user()->is_admin) {
        return redirect()->route('login')->with('error', 'Access denied. Admin only.');
    }
    
    return view('dashboard.inventory');
})->name('admin.dashboard');

Route::get('/user/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    
    return view('dashboard.user');
})->name('user.dashboard');

// Product Management Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/stats', [ProductController::class, 'getStats'])->name('products.stats');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::match(['put', 'post'], '/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::match(['delete', 'post'], '/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Category Management Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/stats', [CategoryController::class, 'getStats'])->name('categories.stats');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::match(['put', 'post'], '/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::match(['delete', 'post'], '/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
