<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 🌐 JALUR PUBLIC VISITOR (Tamu / Mahasiswa)
// =========================================================================
Route::get('/', [PublicController::class, 'beranda'])->name('public.beranda');
Route::get('/public/pendidikan', [PublicController::class, 'pendidikan'])->name('public.pendidikan');
Route::get('/public/penelitian', [PublicController::class, 'penelitian'])->name('public.penelitian');
Route::get('/public/alumni', [PublicController::class, 'alumni'])->name('public.alumni');
Route::get('/public/dokumen', [PublicController::class, 'dokumen'])->name('public.dokumen');
Route::get('/download/dokumen/{id}', [PublicController::class, 'downloadDokumen'])->name('public.dokumen.download')->whereNumber('id');

// =========================================================================
// 🔐 JALUR AUTENTIKASI (Pintu Masuk & Keluar)
// =========================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Anti Brute-Force: Membatasi hit form login maks 5 kali per 1 menit
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
});

// Logout wajib post demi mencegah serangan CSRF
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// =========================================================================
// 💻 JALUR PANEL ADMIN (PROTECTED HUB - Wajib Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // 📊 Main Dashboard Analitik Executif
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 🏫 Modul Kontrol Pendidikan (Prodi, Guru Besar, Visi Misi)
    Route::get('/admin/pendidikan', [AdminController::class, 'pendidikanAdmin'])->name('admin.pendidikan');

    Route::post('/admin/prodi', [AdminController::class, 'storeProdi'])->name('admin.prodi.store');
    Route::put('/admin/prodi/{id}', [AdminController::class, 'updateProdi'])->name('admin.prodi.update')->whereNumber('id');
    Route::delete('/admin/prodi/{id}', [AdminController::class, 'destroyProdi'])->name('admin.prodi.delete')->whereNumber('id');

    Route::post('/admin/pendidikan/gurubesar', [AdminController::class, 'storeGuruBesar'])->name('admin.gurubesar.store');
    Route::put('/admin/pendidikan/gurubesar/{id}', [AdminController::class, 'updateGuruBesar'])->name('admin.gurubesar.update')->whereNumber('id');
    Route::delete('/admin/pendidikan/gurubesar/{id}', [AdminController::class, 'destroyGuruBesar'])->name('admin.gurubesar.delete')->whereNumber('id');

    Route::post('/admin/pendidikan/visi', [AdminController::class, 'storeVisi'])->name('admin.visi.store');
    Route::put('/admin/pendidikan/visi/{id}', [AdminController::class, 'updateVisi'])->name('admin.visi.update')->whereNumber('id');
    Route::delete('/admin/pendidikan/visi/{id}', [AdminController::class, 'destroyVisi'])->name('admin.visi.delete')->whereNumber('id');

    // 📰 Modul Kontrol Berita Hub (Jurnalistik)
    Route::get('/admin/berita', [AdminController::class, 'beritaAdmin'])->name('admin.berita');
    Route::post('/admin/berita', [AdminController::class, 'storeBerita'])->name('admin.berita.store');
    Route::put('/admin/berita/{id}', [AdminController::class, 'updateBerita'])->name('admin.berita.update')->whereNumber('id');
    Route::delete('/admin/berita/{id}', [AdminController::class, 'destroyBerita'])->name('admin.berita.delete')->whereNumber('id');

    // 📁 Modul Pusat Arsip & Media Terpadu (Alumni, Dokumen, Penelitian, Slide)
    Route::get('/admin/arsip', [AdminController::class, 'arsipAdmin'])->name('admin.arsip');
    Route::post('/admin/pengaturan', [AdminController::class, 'updatePengaturan'])->name('admin.pengaturan.update');

    // Hero Slider Carousels (FIXED: Route PUT Edit Aktif & Aman)
    Route::post('/admin/slider', [AdminController::class, 'storeSlider'])->name('admin.slider.store');
    Route::put('/admin/slider/{id}', [AdminController::class, 'updateSlider'])->name('admin.slider.update')->whereNumber('id');
    Route::delete('/admin/slider/{id}', [AdminController::class, 'destroySlider'])->name('admin.slider.delete')->whereNumber('id');

    // Testimoni Jaringan Lulusan (Alumni)
    Route::post('/admin/alumni', [AdminController::class, 'storeAlumni'])->name('admin.alumni.store');
    Route::put('/admin/alumni/{id}', [AdminController::class, 'updateAlumni'])->name('admin.alumni.update')->whereNumber('id');
    Route::delete('/admin/alumni/{id}', [AdminController::class, 'destroyAlumni'])->name('admin.alumni.delete')->whereNumber('id');

    // Berkas Unduhan Dokumen Resmi
    Route::post('/admin/dokumen', [AdminController::class, 'storeDokumen'])->name('admin.dokumen.store');
    Route::delete('/admin/dokumen/{id}', [AdminController::class, 'destroyDokumen'])->name('admin.dokumen.delete')->whereNumber('id');

    // Publikasi Karya Ilmiah & Jurnal
    Route::post('/admin/penelitian', [AdminController::class, 'storePenelitian'])->name('admin.penelitian.store');
    Route::delete('/admin/penelitian/{id}', [AdminController::class, 'destroyPenelitian'])->name('admin.penelitian.delete')->whereNumber('id');

    // Agenda Kolokium & Seminar
    Route::post('/admin/seminar', [AdminController::class, 'storeSeminar'])->name('admin.seminar.store');
    Route::delete('/admin/seminar/{id}', [AdminController::class, 'destroySeminar'])->name('admin.seminar.delete')->whereNumber('id');
});
