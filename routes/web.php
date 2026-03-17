<?php

use App\Http\Controllers\Frontend\community_interaction\ComplaintController;
use App\Http\Controllers\Frontend\community_interaction\ComSatSurController;
use App\Http\Controllers\Frontend\community_interaction\FaqController;
use App\Http\Controllers\Frontend\community_interaction\LicensingProcessController;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\profile\AboutController;
use App\Http\Controllers\Frontend\profile\FieldController;
use App\Http\Controllers\Frontend\profile\OrganizationalStructureController;
use App\Http\Controllers\Frontend\publication\GalleryController;
use App\Http\Controllers\Frontend\publication\NewsController;
use App\Http\Controllers\Frontend\publication\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BannerDashboardController;
use Illuminate\Support\Facades\Route;

// Halaman depan (frontend publik)
Route::get('/', [MainController::class, 'index'])->name('home.index');

// Dashboard Breeze default (untuk user biasa/non-admin)

# == FRONTEND ROUTES ==

# Dashboard
Route::get('/', [MainController::class, 'index'])->name('home.index');

# Profile
Route::get('/tentang', [AboutController::class, 'index'])->name('about.index');
Route::get('/struktur-organisasi', [OrganizationalStructureController::class, 'index'])->name('organization_structure.index');
Route::get('/bidang', [FieldController::class, 'index'])->name('field.index');

# Community Interaction
Route::get('/survei-kepuasan-masyarakat', [ComSatSurController::class, 'index'])->name('com_sat_sur.index');
Route::get('/proses-perizinan', [LicensingProcessController::class, 'index'])->name('licensing_process.index');
Route::get('/pengaduan', [ComplaintController::class, 'index'])->name('complaint.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

# Publication
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');


# == BACKEND ROUTES ==
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
