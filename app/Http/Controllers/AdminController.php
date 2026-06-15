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

class AdminController extends Controller
{
    // =========================================================================
    // MAIN HUB: DASHBOARD EXECUTIVE ANALYTICS LOGS
    // =========================================================================
    public function index()
    {
        $prodi = ProgramStudi::all();
        $berita = Berita::latest()->get();
        $alumni = Alumni::all();
        $dokumen = Dokumen::all();

        return view('admin.dashboard', compact('prodi', 'berita', 'alumni', 'dokumen'));
    }

    // =========================================================================
    // ACCESS GATEWAY: HALAMAN MANAJEMEN ARSIP TERPADU
    // =========================================================================
    public function arsipAdmin()
    {
        $sliders = HeroSlider::all();
        $dokumens = Dokumen::latest()->get();
        $alumnis = Alumni::latest()->get();
        $penat = Penelitian::latest()->get();
        $seminars = Seminar::latest()->get();

        return view('admin.arsip', compact('sliders', 'dokumens', 'alumnis', 'penat', 'seminars'));
    }

    // =========================================================================
    // KONTROL MODUL: PENDIDIKAN (PRODI, GURU BESAR, VISI)
    // =========================================================================
    public function pendidikanAdmin()
    {
        $prodi = ProgramStudi::all();
        $gurubesar = GuruBesar::all();
        $visiData = VisiPendidikan::all();
        return view('admin.pendidikan', compact('prodi', 'gurubesar', 'visiData'));
    }

    public function storeVisi(Request $request)
    {
        $data = $request->validate([
            'judul_visi' => 'required|string|max:255',
            'deskripsi_visi' => 'required|string',
            'gambar_visi' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('gambar_visi')) {
            $imageName = time() . '.' . $request->gambar_visi->extension();
            $request->gambar_visi->move(public_path('img'), $imageName);
            $data['gambar_visi'] = $imageName;
        }

        VisiPendidikan::create($data);
        return back()->with('success', 'Data Visi & Latar Belakang berhasil ditambahkan.');
    }

    public function updateVisi(Request $request, $id)
    {
        $data = $request->validate([
            'judul_visi' => 'required|string|max:255',
            'deskripsi_visi' => 'required|string',
        ]);

        $visi = VisiPendidikan::findOrFail($id);

        if ($request->hasFile('gambar_visi')) {
            $request->validate(['gambar_visi' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
            if ($visi->gambar_visi && File::exists(public_path('img/' . $visi->gambar_visi))) {
                File::delete(public_path('img/' . $visi->gambar_visi));
            }
            $imageName = time() . '.' . $request->gambar_visi->extension();
            $request->gambar_visi->move(public_path('img'), $imageName);
            $data['gambar_visi'] = $imageName;
        }

        $visi->update($data);
        return back()->with('success', 'Data Visi & Latar Belakang berhasil diperbarui.');
    }

    public function destroyVisi($id)
    {
        $visi = VisiPendidikan::findOrFail($id);
        if ($visi->gambar_visi && File::exists(public_path('img/' . $visi->gambar_visi))) {
            File::delete(public_path('img/' . $visi->gambar_visi));
        }
        $visi->delete();
        return back()->with('success', 'Data Visi berhasil dihapus dari sistem.');
    }

    // =========================================================================
    // KONTROL MODUL: PROGRAM STUDI ACTION
    // =========================================================================
    public function storeProdi(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'required|string',
            'search_tags' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        ProgramStudi::create($data);
        return back()->with('success', 'Program Studi baru berhasil ditambahkan.');
    }

    public function updateProdi(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'required|string',
            'search_tags' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        ProgramStudi::findOrFail($id)->update($data);
        return back()->with('success', 'Data Program Studi berhasil diperbarui.');
    }

    public function destroyProdi($id)
    {
        ProgramStudi::findOrFail($id)->delete();
        return back()->with('success', 'Program Studi berhasil dihapus.');
    }

    // =========================================================================
    // KONTROL MODUL: DEWAN GURU BESAR ACTION
    // =========================================================================
    public function storeGuruBesar(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'bidang_keahlian' => 'required|string|max:255',
            'biografi_singkat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img/prof'), $imageName);
            $data['foto'] = $imageName;
        } else {
            $data['foto'] = 'default-prof.png';
        }

        GuruBesar::create($data);
        return back()->with('success', 'Data Guru Besar berhasil ditambahkan.');
    }

    public function updateGuruBesar(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'bidang_keahlian' => 'required|string|max:255',
            'biografi_singkat' => 'nullable|string',
        ]);

        $gb = GuruBesar::findOrFail($id);

        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
            if ($gb->foto && $gb->foto !== 'default-prof.png' && File::exists(public_path('img/prof/' . $gb->foto))) {
                File::delete(public_path('img/prof/' . $gb->foto));
            }
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img/prof'), $imageName);
            $data['foto'] = $imageName;
        }

        $gb->update($data);
        return back()->with('success', 'Data Guru Besar berhasil diperbarui.');
    }

    // METHOD FIX SINKRONISASI: Menghapus data Profesor secara permanen dari DB dan server
    public function destroyGuruBesar($id)
    {
        $gb = GuruBesar::findOrFail($id);
        if ($gb->foto && $gb->foto !== 'default-prof.png' && File::exists(public_path('img/prof/' . $gb->foto))) {
            File::delete(public_path('img/prof/' . $gb->foto));
        }
        $gb->delete();
        return back()->with('success', 'Data Guru Besar berhasil dihapus dari sistem.');
    }

    // =========================================================================
    // KONTROL MODUL: BERITA HUB SYSTEM
    // =========================================================================
    public function beritaAdmin()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita', compact('berita'));
    }

    public function storeBerita(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'konten' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('img'), $imageName);
            $data['cover'] = $imageName;
        } else {
            $data['cover'] = 'news1.jpeg';
        }

        Berita::create($data);
        return back()->with('success', 'Berita baru berhasil diterbitkan.');
    }

    public function updateBerita(Request $request, $id)
    {
        $data = $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string',
            'konten'   => 'required|string',
        ]);

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('cover')) {
            $request->validate(['cover' => 'image|mimes:jpeg,png,jpg,webp|max:2048']);
            if ($berita->cover && $berita->cover !== 'news1.jpeg' && $berita->cover !== 'news2.jpeg' && File::exists(public_path('img/' . $berita->cover))) {
                File::delete(public_path('img/' . $berita->cover));
            }

            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('img'), $imageName);
            $data['cover'] = $imageName;
        }

        $berita->update($data);
        return back()->with('success', 'Artikel berita berhasil diperbarui dan disinkronkan.');
    }

    public function destroyBerita($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->cover && $berita->cover !== 'news1.jpeg' && File::exists(public_path('img/' . $berita->cover))) {
            File::delete(public_path('img/' . $berita->cover));
        }
        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus dari sistem.');
    }

    // =========================================================================
    // KONTROL MODUL: HERO SLIDER (BANNER BERANDA)
    // =========================================================================
    public function storeSlider(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'subtitle'   => 'nullable|string',
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'link_url'   => 'nullable|url'
        ]);

        if ($request->hasFile('image')) {
            $imgName = 'slider_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/slider'), $imgName);

            HeroSlider::create([
                'title'      => $request->title,
                'badge_text' => $request->badge_text,
                'subtitle'   => $request->subtitle,
                'image'      => $imgName,
                'link_url'   => $request->link_url,
            ]);
        }

        return back()->with('success', 'Banner Slide utama berhasil ditambahkan.');
    }

    public function updateSlider(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'subtitle'   => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'link_url'   => 'nullable|url'
        ]);

        $slider = HeroSlider::findOrFail($id);

        $slider->title = $request->title;
        $slider->badge_text = $request->badge_text;
        $slider->subtitle = $request->subtitle;
        $slider->link_url = $request->link_url;

        if ($request->hasFile('image')) {
            if ($slider->image && File::exists(public_path('uploads/slider/' . $slider->image))) {
                File::delete(public_path('uploads/slider/' . $slider->image));
            }

            $imgName = 'slider_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/slider'), $imgName);
            $slider->image = $imgName;
        }

        $slider->save();
        return back()->with('success', 'Banner Hero Slider berhasil diperbarui.');
    }

    public function destroySlider($id)
    {
        $slider = HeroSlider::findOrFail($id);
        if ($slider->image && File::exists(public_path('uploads/slider/' . $slider->image))) {
            File::delete(public_path('uploads/slider/' . $slider->image));
        }
        $slider->delete();

        return back()->with('success', 'Banner Slide berhasil dihapus.');
    }

    // =========================================================================
    // KONTROL MODUL: TESTIMONI ALUMNI
    // =========================================================================
    public function storeAlumni(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:150',
            'tahun_lulus' => 'required|numeric|digits:4',
            'pekerjaan'   => 'required|string|max:255',
            'testimoni'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        if ($request->hasFile('foto')) {
            $fotoName = 'alumni_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/alumni'), $fotoName);
            $data['foto'] = $fotoName;
        }

        Alumni::create($data);
        return back()->with('success', 'Rekam data alumni baru berhasil disimpan.');
    }

    public function updateAlumni(Request $request, $id)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:150',
            'tahun_lulus' => 'required|numeric|digits:4',
            'pekerjaan'   => 'required|string|max:255',
            'testimoni'   => 'required|string',
        ]);

        $alumni = Alumni::findOrFail($id);

        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:1024']);
            if ($alumni->foto && File::exists(public_path('uploads/alumni/' . $alumni->foto))) {
                File::delete(public_path('uploads/alumni/' . $alumni->foto));
            }
            $fotoName = 'alumni_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/alumni'), $fotoName);
            $data['foto'] = $fotoName;
        }

        $alumni->update($data);
        return back()->with('success', 'Data rekam jejak alumni berhasil diperbarui.');
    }

    public function destroyAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        if ($alumni->foto && File::exists(public_path('uploads/alumni/' . $alumni->foto))) {
            File::delete(public_path('uploads/alumni/' . $alumni->foto));
        }
        $alumni->delete();

        return back()->with('success', 'Data alumni berhasil dihapus dari sistem.');
    }

    // =========================================================================
    // KONTROL MODUL: DOWNLOAD BERKAS DOKUMEN
    // =========================================================================
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori'     => 'required|string',
            'file_berkas'  => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ]);

        if ($request->hasFile('file_berkas')) {
            $file = $request->file_berkas;
            $cleanOriginalName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
            $fileName = 'doc_' . time() . '_' . $cleanOriginalName;

            $file->move(public_path('uploads/dokumen'), $fileName);

            Dokumen::create([
                'nama_dokumen' => $request->nama_dokumen,
                'kategori'     => $request->kategori,
                'file_path'    => $fileName
            ]);
        }

        return back()->with('success', 'Berkas dokumen pendaftaran/akademik sukses diunggah.');
    }

    public function destroyDokumen($id)
    {
        $doc = Dokumen::findOrFail($id);
        if (File::exists(public_path('uploads/dokumen/' . $doc->file_path))) {
            File::delete(public_path('uploads/dokumen/' . $doc->file_path));
        }
        $doc->delete();

        return back()->with('success', 'Berkas dokumen telah berhasil dihapus.');
    }

    // =========================================================================
    // KONTROL MODUL: ARSIP JURNAL & PENELITIAN ILMIAH
    // =========================================================================
    public function storePenelitian(Request $request)
    {
        $data = $request->validate([
            'judul_riset' => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'jurnal_nama' => 'required|string|max:255',
            'tahun'       => 'required|numeric|digits:4',
            'link_jurnal' => 'nullable|url'
        ]);

        Penelitian::create($data);
        return back()->with('success', 'Arsip publikasi penelitian baru berhasil disimpan.');
    }

    public function destroyPenelitian($id)
    {
        Penelitian::findOrFail($id)->delete();
        return back()->with('success', 'Data publikasi penelitian berhasil dihapus.');
    }

    // =========================================================================
    // KONTROL MODUL: AGENDA SEMINAR & KOLOKIUM
    // =========================================================================
    public function storeSeminar(Request $request)
    {
        $data = $request->validate([
            'judul_seminar'       => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi_singkat'   => 'required|string',
            'tags_pencarian'      => 'required|string'
        ]);

        Seminar::create($data);
        return back()->with('success', 'Agenda seminar baru berhasil diterbitkan.');
    }

    public function destroySeminar($id)
    {
        Seminar::findOrFail($id)->delete();
        return back()->with('success', 'Agenda seminar berhasil dihapus.');
    }
}
