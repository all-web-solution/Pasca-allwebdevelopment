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
use App\Models\Faq;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; // <-- Wajib ada untuk generate slug otomatis
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
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

        $faqs = Faq::latest()->get();
        $galeris = Galeri::latest()->get();

        $settings = [];
        if (File::exists(storage_path('app/settings.json'))) {
            $settings = json_decode(File::get(storage_path('app/settings.json')), true);
        }

        return view('admin.arsip', compact('sliders', 'dokumens', 'alumnis', 'penat', 'seminars', 'settings', 'faqs', 'galeris'));
    }

    public function updatePengaturan(Request $request)
    {
        $data = $request->validate([
            'stat_alumni_total' => 'required|numeric',
            'stat_alumni_kerja' => 'required|numeric',
            'stat_alumni_mitra' => 'required|numeric',
            'alumni_section_title' => 'required|string|max:255',
            'alumni_section_desc' => 'required|string',
        ]);

        File::put(storage_path('app/settings.json'), json_encode($data));

        return back()->with('success', 'Parameter statistik dan deskripsi global berhasil diperbarui.');
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
    // KONTROL MODUL: PROGRAM STUDI ACTION (SUDAH DISESUAIKAN FIELD BARU)
    // =========================================================================
    public function storeProdi(Request $request)
    {
        // 1. Validasi semua inputan dari form admin/pendidikan termasuk field baru
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'icon'        => 'required|string',
            'search_tags' => 'required|string',
            'deskripsi'   => 'required|string',
            'profil'      => 'nullable|string',
            'visi_misi'   => 'nullable|string',
            'kurikulum'   => 'nullable|string',
            'dosen'       => 'nullable|string',
            'dokumen'     => 'nullable|string',
        ]);

        // 2. Generate slug otomatis dari nama prodi (Contoh: S2 - Manajemen -> s2-manajemen)
        $data['slug'] = Str::slug($request->nama);

        // 3. Masukkan ke database
        ProgramStudi::create($data);
        return back()->with('success', 'Program Studi baru beserta rincian halaman detail berhasil disimpan.');
    }

    public function updateProdi(Request $request, $id)
    {
        // 1. Validasi inputan edit prodi
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'icon'        => 'required|string',
            'search_tags' => 'required|string',
            'deskripsi'   => 'required|string',
            'profil'      => 'nullable|string',
            'visi_misi'   => 'nullable|string',
            'kurikulum'   => 'nullable|string',
            'dosen'       => 'nullable|string',
            'dokumen'     => 'nullable|string',
        ]);

        // 2. Regenerate slug kalau semisal nama prodinya ikut diubah
        $data['slug'] = Str::slug($request->nama);

        // 3. Update data berdasarkan ID prodi
        ProgramStudi::findOrFail($id)->update($data);
        return back()->with('success', 'Data rincian detail Program Studi berhasil diperbarui.');
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

        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $data['prodi_id'] = $user->prodi_id;
        } else {
            $data['prodi_id'] = $request->prodi_id; // Admin Pasca bisa masukin dosen ke prodi tertentu
        }

        // Script Upload Foto seperti biasa...
        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img/prof'), $imageName);
            $data['foto'] = $imageName;
        }

        GuruBesar::create($data);
        return back()->with('success', 'Data Dosen/Guru Besar berhasil ditambahkan.');
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

    public function destroyGuruBesar($id)
    {
        $gb = GuruBesar::findOrFail($id);
        if ($gb->foto && $gb->foto !== 'default-prof.png' && File::exists(public_path('img/prof/' . $gb->foto))) {
            File::delete(public_path('img/prof/' . $gb->foto));
        }
        $gb->delete();
        return back()->with('success', 'Data Guru Besar berhasil dihapus dari sistem.');
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

    // =========================================================================
    // KONTROL MODUL: FAQ (PERTANYAAN UMUM)
    // =========================================================================
    public function storeFaq(Request $request)
    {
        Faq::create($request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']));
        return back()->with('success', 'Pertanyaan FAQ berhasil ditambahkan.');
    }

    public function updateFaq(Request $request, $id)
    {
        Faq::findOrFail($id)->update($request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']));
        return back()->with('success', 'Pertanyaan FAQ berhasil diperbarui.');
    }

    public function destroyFaq($id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'Pertanyaan FAQ berhasil dihapus.');
    }

    // =========================================================================
    // KONTROL MODUL: GALERI & DOKUMENTASI
    // =========================================================================
    public function storeGaleri(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        if ($request->hasFile('gambar')) {
            $imgName = 'galeri_' . time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/galeri'), $imgName);
            $data['gambar'] = $imgName;
        }

        Galeri::create($data);
        return back()->with('success', 'Foto Galeri berhasil diunggah.');
    }

    public function updateGaleri(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $request->validate(['gambar' => 'image|mimes:jpeg,png,jpg,webp|max:3072']);
            if ($galeri->gambar && File::exists(public_path('uploads/galeri/' . $galeri->gambar))) {
                File::delete(public_path('uploads/galeri/' . $galeri->gambar));
            }
            $imgName = 'galeri_' . time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/galeri'), $imgName);
            $data['gambar'] = $imgName;
        }

        $galeri->update($data);
        return back()->with('success', 'Data Galeri berhasil diperbarui.');
    }

    public function destroyGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->gambar && File::exists(public_path('uploads/galeri/' . $galeri->gambar))) {
            File::delete(public_path('uploads/galeri/' . $galeri->gambar));
        }
        $galeri->delete();
        return back()->with('success', 'Foto Galeri berhasil dihapus permanen.');
    }

    // (Fungsi index Dashboard tetap biarkan seperti semula)
    public function index()
    {
        $prodi = ProgramStudi::all();
        $berita = Berita::latest()->get();
        $alumni = Alumni::all();
        $dokumen = Dokumen::all();
        return view('admin.dashboard', compact('prodi', 'berita', 'alumni', 'dokumen'));
    }

    // =========================================================================
    // FUNGSI PANGGILAN HALAMAN (VIEWS) YANG SUDAH DIPECAH MODULAR
    // =========================================================================

    // 1. Pengaturan Teks & Parameter
    public function pengaturanAdmin()
    {
        $settings = [];
        if (File::exists(storage_path('app/settings.json'))) {
            $settings = json_decode(File::get(storage_path('app/settings.json')), true);
        }
        return view('admin.pengaturan', compact('settings'));
    }

    // 2. Banner Hero Slider
    public function sliderAdmin()
    {
        $sliders = HeroSlider::all();
        return view('admin.slider', compact('sliders'));
    }

    // 3. Visi & Profil
    public function visiAdmin()
    {
        $visiData = VisiPendidikan::all();
        return view('admin.visi', compact('visiData'));
    }

    public function prodiAdmin()
    {
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            // Admin Prodi cuma lihat/edit Prodi dia sendiri
            $prodi = ProgramStudi::where('id', $user->prodi_id)->get();
        } else {
            $prodi = ProgramStudi::all();
        }
        return view('admin.prodi', compact('prodi'));
    }

    public function guruBesarAdmin()
    {
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $gurubesar = GuruBesar::where('prodi_id', $user->prodi_id)->latest()->get();
        } else {
            $gurubesar = GuruBesar::latest()->get();
        }

        $semuaProdi = ProgramStudi::all(); // Untuk dropdown select di form
        return view('admin.gurubesar', compact('gurubesar', 'semuaProdi'));
    }

    // 7. Dokumen Unduhan
    public function dokumenAdmin()
    {
        $dokumens = Dokumen::latest()->get();
        return view('admin.dokumen', compact('dokumens'));
    }

    // 8. Galeri
    public function galeriAdmin()
    {
        $galeris = Galeri::latest()->get();
        return view('admin.galeri', compact('galeris'));
    }

    // 9. Alumni
    public function alumniAdmin()
    {
        $alumnis = Alumni::latest()->get();
        return view('admin.alumni', compact('alumnis'));
    }

    // 10. Seminar
    public function seminarAdmin()
    {
        $seminars = Seminar::latest()->get();
        return view('admin.seminar', compact('seminars'));
    }

    // 11. Penelitian
    public function penelitianAdmin()
    {
        $penat = Penelitian::latest()->get();
        return view('admin.penelitian', compact('penat'));
    }

    // 12. FAQ
    public function faqAdmin()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq', compact('faqs'));
    }

    public function beritaAdmin()
    {
        $user = Auth::user();

        if ($user->role === 'admin_prodi') {
            // Admin prodi cuma bisa lihat berita prodinya sendiri
            $berita = Berita::where('prodi_id', $user->prodi_id)->latest()->get();
        } else {
            // Superadmin & Admin Pasca bisa lihat semua berita
            $berita = Berita::latest()->get();
        }

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

        $user = Auth::user();

        // Auto-assign level & prodi berdasarkan Role
        if ($user->role === 'admin_prodi') {
            $data['level'] = 'prodi';
            $data['prodi_id'] = $user->prodi_id;
        } else {
            $data['level'] = $request->level ?? 'pasca';
            $data['prodi_id'] = $request->prodi_id ?? null;
        }

        if ($request->hasFile('cover')) {
            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('img'), $imageName);
            $data['cover'] = $imageName;
        }

        Berita::create($data);
        return back()->with('success', 'Berita berhasil diterbitkan.');
    }

    // (CATATAN: Biarkan fungsi-fungsi POST/PUT/DELETE seperti storeProdi, destroyProdi, dll di bawahnya tetap ada. Jangan dihapus!)

}
