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
use App\Http\Controllers\Backend\BannerIntegritasController;
use App\Http\Controllers\Backend\BannerFaqController;
use App\Http\Controllers\Backend\AdminNewsController;
use App\Http\Controllers\Backend\AdminGalleryController;
use App\Http\Controllers\Backend\AdminVideoController;
use App\Http\Controllers\Backend\KomoditasUnggulanController;
use App\Http\Controllers\Backend\KecamatanController;
use App\Http\Controllers\Backend\SektorController;
use App\Http\Controllers\Backend\PeluangInvestasiController;
use App\Http\Controllers\Backend\PertumbuhanEkonomiController;
use App\Http\Controllers\Backend\SurveyController;
use App\Http\Controllers\Backend\PerizinanTerbitController;
use App\Http\Controllers\Backend\BidangController;
use App\Http\Controllers\Backend\StrukturOrganisasiController;
use App\Http\Controllers\Backend\TentangDpmptspController;
use App\Http\Controllers\Backend\AdminFaqController;
use App\Http\Controllers\Backend\MekanismePengaduanController;

use Illuminate\Support\Facades\Route;

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


// Profile routes (untuk semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


# == BACKEND ROUTES ==
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('backend')->group(function () {
    // Dashboard utama admin
    Route::get('/', [DashboardController::class, 'index'])->name('backend.index');

    Route::resource('banner-dashboard', BannerDashboardController::class)
        ->names('backend.banner-dashboard');
    Route::resource('banner-integritas', BannerIntegritasController::class)
        ->names('backend.banner-integritas')
        ->parameters(['banner-integritas' => 'banner_integritas']);
    Route::resource('banner-faq', BannerFaqController::class)
        ->names('backend.banner-faq');
    Route::resource('news', AdminNewsController::class)
        ->names('backend.news');
    Route::resource('gallery', AdminGalleryController::class)
        ->names('backend.gallery');
    Route::resource('video', AdminVideoController::class)
        ->names('backend.video');
    Route::resource('komoditas-unggulan', KomoditasUnggulanController::class)
        ->names('backend.komoditas-unggulan');
    Route::resource('kecamatan', KecamatanController::class)
        ->names('backend.kecamatan')
        ->parameters(['kecamatan' => 'kecamatan']);
    Route::resource('sektor', SektorController::class)
        ->names('backend.sektor')
        ->parameters(['sektor' => 'sektor']);
    Route::resource('peluang-investasi', PeluangInvestasiController::class)
        ->names('backend.peluang-investasi')
        ->parameters(['peluang-investasi' => 'peluang_investasi'])
        ->except(['show']);
    Route::get(
        'peluang-investasi/get-sektors',
        [PeluangInvestasiController::class, 'getSektorsByKecamatan']
    )
        ->name('backend.peluang-investasi.getSektorsByKecamatan');
    Route::resource('pertumbuhan-ekonomi', PertumbuhanEkonomiController::class)
        ->names('backend.pertumbuhan-ekonomi')
        ->parameters(['pertumbuhan-ekonomi' => 'pertumbuhan_ekonomi']);
    Route::resource('survey', SurveyController::class)
        ->names('backend.survey')
        ->parameters(['survey' => 'survey']);
    Route::resource('perizinan-terbit', PerizinanTerbitController::class)
        ->names('backend.perizinan-terbit')
        ->parameters(['perizinan-terbit' => 'perizinan_terbit']);
    Route::resource('bidang', BidangController::class)
        ->names('backend.bidang')
        ->parameters(['bidang' => 'bidang']);
    Route::resource('struktur-organisasi', StrukturOrganisasiController::class)
        ->names('backend.struktur-organisasi')
        ->parameters(['struktur-organisasi' => 'struktur_organisasi'])
        ->except(['show']);   // ← Tambahkan baris ini
    Route::get('/struktur-organisasi/check-pejabat', [StrukturOrganisasiController::class, 'checkPejabat'])
        ->name('backend.struktur-organisasi.check-pejabat');
    Route::resource('tentang-dpmptsp', TentangDpmptspController::class)
        ->names('backend.tentang-dpmptsp');
    Route::resource('faq', AdminFaqController::class)
        ->names('backend.faq');
    Route::resource('mekanisme-pengaduan', MekanismePengaduanController::class)
        ->names('backend.mekanisme-pengaduan')
        ->parameters(['mekanisme-pengaduan' => 'mekanisme_pengaduan']);
    Route::resource('layanan-utama', \App\Http\Controllers\Backend\LayananUtamaController::class)
        ->names('backend.layanan-utama')
        ->parameters(['layanan-utama' => 'layanan_utama']);
    Route::resource('layanan-perizinan', \App\Http\Controllers\Backend\LayananPerizinanController::class)
        ->names('backend.layanan-perizinan')
        ->parameters(['layanan-perizinan' => 'layanan_perizinan']);
    Route::resource('investment', \App\Http\Controllers\Backend\InvestmentController::class)
        ->names('backend.investment')
        ->except(['show']);
    Route::resource('perbup', \App\Http\Controllers\Backend\PerbupController::class)
        ->names('backend.perbup')
        ->parameters(['perbup' => 'perbup'])
        ->except(['show', 'destroy']);
});

Route::middleware(['auth', 'role:superadmin'])->prefix('backend')->group(function () {

    // Manajemen Pengguna
    Route::resource('users', \App\Http\Controllers\Backend\UserController::class)
        ->names('backend.users')
        ->parameters(['users' => 'user']);
    Route::get('app-logs', [\App\Http\Controllers\Backend\AppLogController::class, 'index'])
        ->name('backend.app-logs.index');

    Route::get('app-logs/{app_log}', [\App\Http\Controllers\Backend\AppLogController::class, 'show'])
        ->name('backend.app-logs.show');

    // App Log (nanti kita buat kalau sudah selesai users)
    // Route::resource('app-logs', AppLogController::class)->names('backend.app-logs');

});


require __DIR__ . '/auth.php';
