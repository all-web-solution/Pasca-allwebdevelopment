<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\GuruBesar;
use App\Models\HeroSlider;
use App\Models\Penelitian;
use App\Models\ProgramStudi;
use App\Models\Seminar;
use App\Models\VisiPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PublicController extends Controller
{
    // =========================================================================
    // MAIN HUB: HALAMAN BERANDA UTAMA (SINKRON DATA SEEDER & HERO)
    // =========================================================================
    public function beranda()
    {
        $sliders = HeroSlider::all();
        $prodi = ProgramStudi::all();

        // Menarik semua data berita terbaru untuk slider berita horizontal
        $berita = Berita::latest()->get();

        return view('welcome', compact('sliders', 'prodi', 'berita'));
    }

    // =========================================================================
    // AKSI DOWNLOAD: REAL-TIME HITUNGAN UNDUHAN DOKUMEN
    // =========================================================================
    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        // Naikkan hitungan total download berkas secara real-time
        $dokumen->increment('download_count');

        $filePath = public_path('uploads/dokumen/' . $dokumen->file_path);

        if (!File::exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan di server penyimpanan.');
        }

        return response()->download($filePath);
    }

    // =========================================================================
    // HALAMAN SUB-MENU JARINGAN ALUMNI
    // =========================================================================
    public function alumni()
    {
        $sliders = HeroSlider::all();
        $alumni = Alumni::latest()->get();
        return view('public.alumni', compact('sliders', 'alumni'));
    }

    // =========================================================================
    // HALAMAN REPOSITORI UNDUHAN DOKUMEN RESMI
    // =========================================================================
    public function dokumen()
    {
        $sliders = HeroSlider::all();
        $dokumen = Dokumen::all();
        return view('public.dokumen', compact('sliders', 'dokumen'));
    }

    // =========================================================================
    // HALAMAN PROFIL PENDIDIKAN, STRUKTUR PRODI & GURU BESAR
    // =========================================================================
    public function pendidikan()
    {
        $sliders = HeroSlider::all();
        $prodi = ProgramStudi::all();
        $gurubesar = GuruBesar::all();
        $visi = VisiPendidikan::first();
        return view('public.pendidikan', compact('sliders', 'prodi', 'gurubesar', 'visi'));
    }

    // =========================================================================
    // HALAMAN MUTU RISET, SEMINAR & PUBLIKASI JURNAL
    // =========================================================================
    public function penelitian()
    {
        $sliders = HeroSlider::all();
        $seminar = Seminar::latest()->get();
        $penelitian = Penelitian::latest()->get();
        return view('public.penelitian', compact('sliders', 'seminar', 'penelitian'));
    }
}
