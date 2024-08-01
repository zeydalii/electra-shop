<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OverviewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/store-chart/{id}', [HomeController::class, 'store'])->name('store-chart');

Route::get('/about', function () {
    return view('about', ['title' => 'About Page', ]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact Page', ]);
});

Route::get('/payment', function () {
    return view('payment', ['title' => 'Payment Page', ]);
});

Route::get('/chart', [ChartController::class, 'index']);
Route::delete('/chart/{id}', [ChartController::class, 'destroy'])->name('chart.destroy');
Route::post('/chart', [ChartController::class, 'store'])->name('chart.store');

Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/admin/login', [AdminLoginController::class, 'authenticate'])->middleware('guest');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->middleware(['auth']);

Route::get('/admin/register', [AdminRegisterController::class, 'index'])->name('register-admin')->middleware('guest');
Route::post('/admin/register', [AdminRegisterController::class, 'store'])->middleware('guest');

Route::get('/admin', [OverviewsController::class, 'index'])->middleware(['auth']);

Route::get('/admin/admins', [AdminController::class, 'index'])->middleware(['auth']);
Route::post('/admin/admins', [AdminController::class, 'store'])->middleware(['auth']);
Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->middleware(['auth']);
Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->middleware(['auth']);

Route::get('/admin/products', [ProductController::class, 'index'])->middleware(['auth']);
Route::post('/admin/products', [ProductController::class, 'store'])->middleware(['auth']);
Route::put('/admin/products/{id}', [ProductController::class, 'update'])->middleware(['auth']);
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->middleware(['auth']);

Route::get('/admin/transactions', [TransactionController::class, 'index'])->middleware(['auth']);
Route::get('/admin/transactions/{id}', [TransactionController::class, 'show'])->middleware(['auth']);
Route::delete('/admin/transactions/{id}', [TransactionController::class, 'destroy'])->middleware(['auth']);