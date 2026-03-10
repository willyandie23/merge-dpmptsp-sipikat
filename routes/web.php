<?php

use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\publication\NewsController;
use App\Http\Controllers\Frontend\publication\GalleryController;
use App\Http\Controllers\Frontend\publication\VideoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


# == FRONTEND ROUTES ==

# Publication
Route::get('/', [MainController::class, 'index'])->name('home.index');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin|superadmin')->group(function () {
});

require __DIR__.'/auth.php';
