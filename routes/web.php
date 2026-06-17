<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 🌐 JALUR PUBLIC VISITOR
// =========================================================================
Route::get('/', [PublicController::class, 'beranda'])->name('public.beranda');
Route::get('/public/pendidikan', [PublicController::class, 'pendidikan'])->name('public.pendidikan');
Route::get('/public/penelitian', [PublicController::class, 'penelitian'])->name('public.penelitian');
Route::get('/public/alumni', [PublicController::class, 'alumni'])->name('public.alumni');
Route::get('/public/dokumen', [PublicController::class, 'dokumen'])->name('public.dokumen');
Route::get('/download/dokumen/{id}', [PublicController::class, 'downloadDokumen'])->name('public.dokumen.download')->whereNumber('id');
Route::get('/public/galeri', [PublicController::class, 'galeri'])->name('public.galeri');

// INI ROUTE PRODI DINAMIS YANG BENAR (Mencegah error Undefined variable)
Route::get('/prodi/{slug}', [PublicController::class, 'prodiDetail'])->name('public.prodi-detail');

// =========================================================================
// 🔐 JALUR AUTENTIKASI
// =========================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// =========================================================================
// 💻 JALUR PANEL ADMIN
// =========================================================================
// =========================================================================
// 💻 JALUR PANEL ADMIN (SUDAH DIPECAH MODULAR)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // 1. Dashboard Utama
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 2. Modul Pengaturan Beranda
    Route::get('/admin/pengaturan', [AdminController::class, 'pengaturanAdmin'])->name('admin.pengaturan');
    Route::post('/admin/pengaturan', [AdminController::class, 'updatePengaturan'])->name('admin.pengaturan.update');
    Route::get('/admin/slider', [AdminController::class, 'sliderAdmin'])->name('admin.slider');
    Route::post('/admin/slider', [AdminController::class, 'storeSlider'])->name('admin.slider.store');
    Route::put('/admin/slider/{id}', [AdminController::class, 'updateSlider'])->name('admin.slider.update')->whereNumber('id');
    Route::delete('/admin/slider/{id}', [AdminController::class, 'destroySlider'])->name('admin.slider.delete')->whereNumber('id');

    // 3. Modul Akademik & Pendidikan
    Route::get('/admin/visi', [AdminController::class, 'visiAdmin'])->name('admin.visi');
    Route::post('/admin/visi', [AdminController::class, 'storeVisi'])->name('admin.visi.store');
    Route::put('/admin/visi/{id}', [AdminController::class, 'updateVisi'])->name('admin.visi.update')->whereNumber('id');
    Route::delete('/admin/visi/{id}', [AdminController::class, 'destroyVisi'])->name('admin.visi.delete')->whereNumber('id');

    Route::get('/admin/prodi', [AdminController::class, 'prodiAdmin'])->name('admin.prodi');
    Route::post('/admin/prodi', [AdminController::class, 'storeProdi'])->name('admin.prodi.store');
    Route::put('/admin/prodi/{id}', [AdminController::class, 'updateProdi'])->name('admin.prodi.update')->whereNumber('id');
    Route::delete('/admin/prodi/{id}', [AdminController::class, 'destroyProdi'])->name('admin.prodi.delete')->whereNumber('id');

    Route::get('/admin/gurubesar', [AdminController::class, 'guruBesarAdmin'])->name('admin.gurubesar');
    Route::post('/admin/gurubesar', [AdminController::class, 'storeGuruBesar'])->name('admin.gurubesar.store');
    Route::put('/admin/gurubesar/{id}', [AdminController::class, 'updateGuruBesar'])->name('admin.gurubesar.update')->whereNumber('id');
    Route::delete('/admin/gurubesar/{id}', [AdminController::class, 'destroyGuruBesar'])->name('admin.gurubesar.delete')->whereNumber('id');

    // 4. Modul Arsip & Media
    Route::get('/admin/berita', [AdminController::class, 'beritaAdmin'])->name('admin.berita');
    Route::post('/admin/berita', [AdminController::class, 'storeBerita'])->name('admin.berita.store');
    Route::put('/admin/berita/{id}', [AdminController::class, 'updateBerita'])->name('admin.berita.update')->whereNumber('id');
    Route::delete('/admin/berita/{id}', [AdminController::class, 'destroyBerita'])->name('admin.berita.delete')->whereNumber('id');

    Route::get('/admin/dokumen', [AdminController::class, 'dokumenAdmin'])->name('admin.dokumen');
    Route::post('/admin/dokumen', [AdminController::class, 'storeDokumen'])->name('admin.dokumen.store');
    Route::delete('/admin/dokumen/{id}', [AdminController::class, 'destroyDokumen'])->name('admin.dokumen.delete')->whereNumber('id');

    Route::get('/admin/galeri', [AdminController::class, 'galeriAdmin'])->name('admin.galeri');
    Route::post('/admin/galeri', [AdminController::class, 'storeGaleri'])->name('admin.galeri.store');
    Route::put('/admin/galeri/{id}', [AdminController::class, 'updateGaleri'])->name('admin.galeri.update')->whereNumber('id');
    Route::delete('/admin/galeri/{id}', [AdminController::class, 'destroyGaleri'])->name('admin.galeri.delete')->whereNumber('id');

    // 5. Modul Interaksi & Data Publik
    Route::get('/admin/alumni', [AdminController::class, 'alumniAdmin'])->name('admin.alumni');
    Route::post('/admin/alumni', [AdminController::class, 'storeAlumni'])->name('admin.alumni.store');
    Route::put('/admin/alumni/{id}', [AdminController::class, 'updateAlumni'])->name('admin.alumni.update')->whereNumber('id');
    Route::delete('/admin/alumni/{id}', [AdminController::class, 'destroyAlumni'])->name('admin.alumni.delete')->whereNumber('id');

    Route::get('/admin/seminar', [AdminController::class, 'seminarAdmin'])->name('admin.seminar');
    Route::post('/admin/seminar', [AdminController::class, 'storeSeminar'])->name('admin.seminar.store');
    Route::delete('/admin/seminar/{id}', [AdminController::class, 'destroySeminar'])->name('admin.seminar.delete')->whereNumber('id');

    Route::get('/admin/penelitian', [AdminController::class, 'penelitianAdmin'])->name('admin.penelitian');
    Route::post('/admin/penelitian', [AdminController::class, 'storePenelitian'])->name('admin.penelitian.store');
    Route::delete('/admin/penelitian/{id}', [AdminController::class, 'destroyPenelitian'])->name('admin.penelitian.delete')->whereNumber('id');

    Route::get('/admin/faq', [AdminController::class, 'faqAdmin'])->name('admin.faq');
    Route::post('/admin/faq', [AdminController::class, 'storeFaq'])->name('admin.faq.store');
    Route::put('/admin/faq/{id}', [AdminController::class, 'updateFaq'])->name('admin.faq.update');
    Route::delete('/admin/faq/{id}', [AdminController::class, 'destroyFaq'])->name('admin.faq.delete');
});
