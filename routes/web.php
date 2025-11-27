<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// --- FRONTEND (Halaman Utama) ---
Route::get('/', [ProductController::class, 'showHomePage'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


// --- ADMIN PANEL (CRUD AJAX) ---
Route::get('/admin', [ProductController::class, 'index'])->name('admin.index');
Route::post('/admin/store', [ProductController::class, 'store'])->name('admin.store');
Route::post('/admin/update/{id}', [ProductController::class, 'update'])->name('admin.update');
Route::delete('/admin/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.destroy');
Route::post('/pay', [MidtransController::class, 'makePayment'])->name('pay');
