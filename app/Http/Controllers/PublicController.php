<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Galeri;
use App\Models\GuruBesar;
use App\Models\HeroSlider;
use App\Models\Penelitian;
use App\Models\ProgramStudi;
use App\Models\Seminar;
use App\Models\VisiPendidikan;
use App\Models\Faq; // <-- WAJIB DIPANGGIL
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
    // HALAMAN SUB-MENU JARINGAN ALUMNI & GALERI
    // =========================================================================
    public function galeri()
    {
        $sliders = HeroSlider::all();
        $galeris = Galeri::latest()->get();
        return view('public.galeri', compact('sliders', 'galeris'));
    }

    public function alumni()
    {
        $sliders = HeroSlider::all();
        $alumni = Alumni::latest()->get();

        // Tarik data pengaturan dinamis dari JSON
        $settings = [];
        if (File::exists(storage_path('app/settings.json'))) {
            $settings = json_decode(File::get(storage_path('app/settings.json')), true);
        }

        return view('public.alumni', compact('sliders', 'alumni', 'settings'));
    }

    // =========================================================================
    // HALAMAN REPOSITORI UNDUHAN DOKUMEN RESMI & FAQ
    // =========================================================================
    public function dokumen()
    {
        $sliders = HeroSlider::all();
        $dokumen = Dokumen::all();
        $faqs = Faq::latest()->get(); // <-- TARIK DATA FAQ DARI DATABASE

        // Parsing variabel $faqs ke halaman public.dokumen
        return view('public.dokumen', compact('sliders', 'dokumen', 'faqs'));
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

        // TAMBAHKAN BARIS INI BIAR DATA BERITA IKUT KEBAWA KE HALAMAN PENDIDIKAN
        $berita = Berita::latest()->get();

        // JANGAN LUPA TAMBAHKAN 'berita' DI DALAM COMPACT
        return view('public.pendidikan', compact('sliders', 'prodi', 'gurubesar', 'visi', 'berita'));
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

    // =========================================================================
    // HALAMAN DETAIL PROGRAM STUDI DINAMIS (YANG TADI ILANG)
    // =========================================================================
    public function prodiDetail($slug)
    {
        $sliders = HeroSlider::all();

        // Cari prodi berdasarkan slug yang diklik di URL, kalau nggak ada lempar 404
        $prodi = ProgramStudi::where('slug', $slug)->firstOrFail();

        return view('public.prodi-detail', compact('sliders', 'prodi'));
    }
}
