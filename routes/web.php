<?php

use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BannerDashboardController;
use Illuminate\Support\Facades\Route;

// Halaman depan (frontend publik)
Route::get('/', [MainController::class, 'index'])->name('home.index');

// Dashboard Breeze default (untuk user biasa/non-admin)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (untuk semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Area Admin / Backend (hanya admin & superadmin)
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('backend')->group(function () {
    // Dashboard utama admin
    Route::get('/', [DashboardController::class, 'index'])->name('backend.index');

    Route::resource('banner-dashboard', BannerDashboardController::class)
        ->names('backend.banner-dashboard');

});

require __DIR__ . '/auth.php';
