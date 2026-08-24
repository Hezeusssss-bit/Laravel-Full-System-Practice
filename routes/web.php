<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    
    $admins = \App\Models\User::where('is_admin', true)->get();
    $users = \App\Models\User::where('is_admin', false)->get();
    return view('dashboard.admin', compact('admins', 'users'));
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
