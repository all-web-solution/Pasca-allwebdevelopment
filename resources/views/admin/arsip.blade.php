@extends('layouts.admin')

@section('title', 'Pusat Manajemen Arsip & Media - Admin')
@section('page_title', 'Pusat Kontrol Informasi Publik')

@section('styles')
<style>
    /* ========================================================================= */
    /* MODAL DYNAMIC SYSTEM STYLE */
    /* ========================================================================= */
    .admin-modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        display: flex; align-items: center; justify-content: center;
        z-index: 2000; opacity: 0; pointer-events: none; transition: var(--transition);
    }
    .admin-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .admin-modal-window {
        background: var(--card-bg); border: 1px solid var(--border-color);
        width: 90%; max-width: 600px; padding: 40px; border-radius: 20px;
        position: relative; transform: scale(0.94); transition: var(--transition);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
    }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    .modal-close-trigger { 
        position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; 
        color: var(--text-muted); width: 36px; height: 36px; background: var(--light); 
        display: flex; align-items: center; justify-content: center; border-radius: 50%; 
    }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }

    .modal-show-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 20px; text-transform: uppercase; }
    .modal-data-strip { background: var(--light); padding: 14px 20px; border-radius: 10px; font-size: 0.9rem; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; border: 1px solid var(--border-color); }
    .modal-data-strip i { color: var(--primary); }
    
    .panel-section-divider { margin: 40px 0; border: 0; border-top: 1px dashed var(--border-color); }
    
    /* --- ACTION BUTTONS PLATFORM --- */
    .btn-action-trigger.edit-type { color: #D97706; }
    .btn-action-trigger.edit-type:hover { background: #D97706; color: white; border-color: #D97706; }
    .btn-action-trigger.show-type { color: #3B82F6; }
    .btn-action-trigger.show-type:hover { background: #3B82F6; color: white; border-color: #3B82F6; }
    .action-row-buttons { display: flex; gap: 6px; justify-content: flex-end; align-items: center; }
</style>
@endsection

@section('content')
    @if(session('success'))
        <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script>
    @endif

    <!-- PENGATURAN PARAMETER GLOBAL -->
    <div class="control-container-card" id="kontrol-parameter">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-sliders" style="color:var(--primary)"></i> Pengaturan Parameter & Angka Statistik Global</h3>
        </div>
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Total Alumni Terdata (Counter)</label>
                    <input type="number" name="stat_alumni_total" value="{{ $settings['stat_alumni_total'] ?? '1200' }}" required>
                </div>
                <div class="form-input-cell">
                    <label>Persentase Serapan Kerja Alumni (%)</label>
                    <input type="number" name="stat_alumni_kerja" value="{{ $settings['stat_alumni_kerja'] ?? '86' }}" required>
                </div>
                <div class="form-input-cell">
                    <label>Mitra Instansi Pengguna Lulusan</label>
                    <input type="number" name="stat_alumni_mitra" value="{{ $settings['stat_alumni_mitra'] ?? '32' }}" required>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 1;">
                    <label>Judul Sub-Seksi Deskripsi Alumni</label>
                    <input type="text" name="alumni_section_title" value="{{ $settings['alumni_section_title'] ?? 'Kiprah Nyata di Ruang Publik' }}" required>
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Isi Panjang Teks Deskripsi Blok Alumni</label>
                    <textarea name="alumni_section_desc" rows="3" required>{{ $settings['alumni_section_desc'] ?? 'Alumni Pascasarjana IAIN Curup berkomitmen mengaktualisasikan keilmuan sosiologis religius melalui berbagai bentuk pengabdian transformatif yang adaptif terhadap dinamika zaman. Kurikulum berbasis riset mendalam membekali para lulusan untuk menjadi problem solver di berbagai sektor krusial kemasyarakatan.' }}</textarea>
                </div>
                <button type="submit" class="btn-modern">Perbarui Parameter</button>
            </div>
        </form>
    </div>

    <hr class="panel-section-divider">

    <!-- MANAJEMEN BANNER HERO SLIDER -->
    <div class="control-container-card" id="kontrol-slider">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-images" style="color:var(--primary)"></i> Tambah Banner Hero Slider</h3>
        </div>
        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Judul Utama Banner</label>
                    <input type="text" name="title" required placeholder="Contoh: Membangun Generasi Unggul">
                </div>
                <div class="form-input-cell">
                    <label>Label Badge Atas (Hero Badge)</label>
                    <input type="text" name="badge_text" placeholder="Contoh: Penerimaan Mahasiswa Baru">
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Link URL Button (Opsional)</label>
                    <input type="url" name="link_url" placeholder="Contoh: https://siakad.iaincurup.ac.id">
                </div>
                <div class="form-input-cell">
                    <label>File Gambar Background Banner (.jpg / .png / .webp)</label>
                    <input type="file" name="image" required>
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Sub-judul / Deskripsi Banner</label>
                    <textarea name="subtitle" rows="2" placeholder="Tulis deskripsi singkat banner beranda..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Simpan Slide</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Judul Slide</th>
                        <th>Badge Label</th>
                        <th>Nama Berkas Media</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $s)
                    <tr>
                        <td><strong>{{ Str::limit($s->title, 40) }}</strong></td>
                        <td><span class="badge-status status-success">{{ $s->badge_text ?? '-' }}</span></td>
                        <td><code>{{ Str::limit($s->image, 25) }}</code></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-slider" data-title="{{ $s->title }}" data-badge="{{ $s->badge_text }}" data-subtitle="{{ $s->subtitle }}" data-link="{{ $s->link_url }}" data-image="{{ asset('uploads/slider/' . $s->image) }}"><i class="fa-solid fa-eye"></i></button>
                                
                                <!-- TOMBOL EDIT SLIDER KEBAL CRASH -->
                                <button class="btn-action-trigger edit-type btn-edit-slider" 
                                        data-id="{{ $s->id }}" 
                                        data-title="{{ $s->title }}" 
                                        data-badge="{{ $s->badge_text }}" 
                                        data-link="{{ $s->link_url }}" 
                                        data-image="{{ asset('uploads/slider/' . $s->image) }}"
                                        data-subtitle="{{ $s->subtitle }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <form action="{{ route('admin.slider.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus slide banner ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr class="panel-section-divider">

    <!-- UPLOAD DOKUMEN AKADEMIK -->
    <div class="control-container-card" id="kontrol-dokumen">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-file-arrow-up" style="color:var(--primary)"></i> Upload Berkas Dokumen Akademik</h3>
        </div>
        <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Nama Dokumen Resmi</label>
                    <input type="text" name="nama_dokumen" required placeholder="Contoh: Form Pendaftaran Calon Mahasiswa S2">
                </div>
                <div class="form-input-cell" style="flex: 1;">
                    <label>Klasifikasi Kategori</label>
                    <select name="kategori" required>
                        <option value="Formulir">Formulir</option>
                        <option value="Panduan">Buku Panduan</option>
                        <option value="Kurikulum">Kurikulum</option>
                    </select>
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Pilih File Dokumen (.pdf, .doc, .docx, .xls, .xlsx - Maks 10MB)</label>
                    <input type="file" name="file_berkas" required>
                </div>
                <button type="submit" class="btn-modern">Unggah Berkas</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Nama Dokumen</th>
                        <th>Kategori</th>
                        <th>Total Diunduh</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dokumens as $d)
                    <tr>
                        <td><strong>{{ $d->nama_dokumen }}</strong></td>
                        <td><span class="badge-status status-warning" style="text-transform: uppercase; font-size: 0.75rem;">{{ $d->kategori }}</span></td>
                        <td><strong>{{ $d->download_count }} <i class="fa-solid fa-download" style="font-size: 0.8rem; color: var(--primary);"></i></strong></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <form action="{{ route('admin.dokumen.delete', $d->id) }}" method="POST" onsubmit="return confirm('Hapus file dokumen ini permanen?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr class="panel-section-divider">

    <!-- REKAM DATA ALUMNI -->
    <div class="control-container-card" id="kontrol-alumni">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-user-graduate" style="color:var(--primary)"></i> Input Rekam Data Alumni</h3>
        </div>
        <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Nama Lengkap Alumni beserta Gelar</label>
                    <input type="text" name="nama" required placeholder="Contoh: Dr. H. M. Yusuf, M.Ag.">
                </div>
                <div class="form-input-cell" style="flex: 1;">
                    <label>Tahun Kelulusan</label>
                    <input type="number" name="tahun_lulus" required placeholder="Contoh: 2025">
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Pekerjaan / Jabatan Saat Ini</label>
                    <input type="text" name="pekerjaan" required placeholder="Contoh: Kepala Kemenag Rejang Lebong">
                </div>
                <div class="form-input-cell">
                    <label>Foto Formal Alumni</label>
                    <input type="file" name="foto">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Pesan Kesan & Testimoni</label>
                    <textarea name="testimoni" rows="3" required placeholder="Tulis kutipan testimoni alumni selama kuliah..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Simpan Alumni</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Nama Alumni</th>
                        <th>Tahun Lulus</th>
                        <th>Pekerjaan / Jabatan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumnis as $al)
                    <tr>
                        <td><strong>{{ $al->nama }}</strong></td>
                        <td><code>Angkatan {{ $al->tahun_lulus }}</code></td>
                        <td>{{ $al->pekerjaan }}</td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-alumni" data-nama="{{ $al->nama }}" data-lulus="{{ $al->tahun_lulus }}" data-kerja="{{ $al->pekerjaan }}" data-testi="{{ $al->testimoni }}" data-foto="{{ $al->foto ? asset('uploads/alumni/' . $al->foto) : asset('img/prof/default-prof.png') }}"><i class="fa-solid fa-eye"></i></button>
                                <form action="{{ route('admin.alumni.delete', $al->id) }}" method="POST" onsubmit="return confirm('Hapus data testimoni alumni ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr class="panel-section-divider">

    <!-- AGENDA SEMINAR -->
    <div class="control-container-card" id="kontrol-seminar">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-calendar-days" style="color:var(--primary)"></i> Tambah Agenda Seminar & Kolokium</h3>
        </div>
        <form action="{{ route('admin.seminar.store') }}" method="POST" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Judul Utama Agenda Seminar</label>
                    <input type="text" name="judul_seminar" required placeholder="Contoh: Seminar Nasional Moderasi Islam">
                </div>
                <div class="form-input-cell" style="flex: 1;">
                    <label>Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" required>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Kata Kunci Pencarian (Live Search Tags)</label>
                    <input type="text" name="tags_pencarian" required placeholder="Contoh: seminar nasional moderasi beragama digital">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Deskripsi / Cakupan Singkat Pembahasan Seminar</label>
                    <textarea name="deskripsi_singkat" rows="2" required placeholder="Tulis ringkasan info agenda..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Terbitkan Agenda</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Judul Agenda Seminar</th>
                        <th>Tanggal Acara</th>
                        <th>Kata Kunci Search</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seminars as $sm)
                    <tr>
                        <td><strong>{{ Str::limit($sm->judul_seminar, 45) }}</strong></td>
                        <td><code>{{ \Carbon\Carbon::parse($sm->tanggal_pelaksanaan)->format('d-m-Y') }}</code></td>
                        <td><small>{{ Str::limit($sm->tags_pencarian, 35) }}</small></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <form action="{{ route('admin.seminar.delete', $sm->id) }}" method="POST" onsubmit="return confirm('Hapus agenda seminar ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr class="panel-section-divider">

    <!-- ARSIP RISET PENELITIAN -->
    <div class="control-container-card" id="kontrol-penelitian">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-book-bookmark" style="color:var(--primary)"></i> Input Publikasi Jurnal & Riset Penelitian</h3>
        </div>
        <form action="{{ route('admin.penelitian.store') }}" method="POST" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="grid-column: span 2;">
                    <label>Judul Artikel Riset Ilmiah</label>
                    <input type="text" name="judul_riset" required placeholder="Contoh: Analisis Sosiologis Religius Kontemporer Kurikulum Transformatif">
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Nama Penulis / Tim Peneliti</label>
                    <input type="text" name="penulis" required placeholder="Contoh: Prof. Dr. Ahmad Subarjo & Team">
                </div>
                <div class="form-input-cell">
                    <label>Nama Media Jurnal Publikasi</label>
                    <input type="text" name="jurnal_nama" required placeholder="Contoh: Jurnal Arabiyat Sinta 2 / Scopus Indexed">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 1;">
                    <label>Tahun Publikasi</label>
                    <input type="number" name="tahun" required placeholder="Contoh: 2026">
                </div>
                <div class="form-input-cell" style="flex: 2;">
                    <label>URL Tautan Link OJS Jurnal / PDF (Opsional)</label>
                    <input type="url" name="link_jurnal" placeholder="Contoh: https://journal.iaincurup.ac.id/index.php/index">
                </div>
                <button type="submit" class="btn-modern">Simpan Riset</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Judul Riset Ilmiah</th>
                        <th>Penulis Utama</th>
                        <th>Media Jurnal</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penat as $pn)
                    <tr>
                        <td><strong>{{ Str::limit($pn->judul_riset, 50) }}</strong></td>
                        <td>{{ $pn->penulis }}</td>
                        <td><code>{{ $pn->jurnal_nama }} ({{ $pn->tahun }})</code></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <form action="{{ route('admin.penelitian.delete', $pn->id) }}" method="POST" onsubmit="return confirm('Hapus data arsip riset ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 1. MODAL VIEW BANNER SLIDER -->
    <div class="admin-modal-overlay" id="modalShowSlider">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalShowSlider')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-images"></i> Media Preview</div>
            <div id="vSliderImage" style="width:100%; height:220px; border-radius:12px; background-size:cover; background-position:center; margin-bottom:20px; border:1px solid var(--border-color);"></div>
            <h2 id="vSliderTitle" style="font-size:1.4rem; font-weight:800; color:var(--dark); margin-bottom:10px;"></h2>
            <div class="modal-data-strip"><i class="fa-solid fa-bookmark"></i> <p><b>Badge Text:</b> <span id="vSliderBadge"></span></p></div>
            <div class="modal-data-strip"><i class="fa-solid fa-link"></i> <p><b>Redirect Target:</b> <span id="vSliderLink"></span></p></div>
            <p id="vSliderSubtitle" style="line-height:1.6; font-size:0.92rem; color:var(--text-muted); text-align:justify; margin-top:15px;"></p>
        </div>
    </div>

    <!-- 2. MODAL EDIT BANNER SLIDER (BARU & LENGKAP) -->
    <div class="admin-modal-overlay" id="modalEditSlider">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditSlider')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Perbarui Banner Hero Slider</h3>
            <form id="formEditSlider" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Judul Utama Banner</label>
                        <input type="text" id="editSliderTitle" name="title" required>
                    </div>
                    <div class="form-input-cell">
                        <label>Label Badge Atas</label>
                        <input type="text" id="editSliderBadge" name="badge_text">
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Link URL Redirect Button</label>
                        <input type="url" id="editSliderLink" name="link_url">
                    </div>
                </div>
                <div class="form-flex-row" style="align-items: center; gap: 20px;">
                    <div id="editSliderImagePreview" style="width: 100px; height: 75px; border-radius: 8px; background-size: cover; background-position: center; border: 1px solid var(--border-color); flex-shrink: 0;"></div>
                    <div class="form-input-cell">
                        <label>Ganti Gambar Slide Background (Opsional)</label>
                        <input type="file" id="editSliderImageInput" name="image" accept="image/*">
                    </div>
                </div>
                <div class="form-flex-row" style="flex-direction:column; gap:15px;">
                    <div class="form-input-cell" style="width:100%;">
                        <label>Sub-judul / Deskripsi Banner</label>
                        <textarea id="editSliderSubtitle" name="subtitle" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn-modern" style="width:fit-content; align-self:flex-end;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VIEW ALUMNI -->
    <div class="admin-modal-overlay" id="modalShowAlumni">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalShowAlumni')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-user-graduate"></i> Profil Lulusan</div>
            <div style="display:flex; gap:20px; align-items:center; margin-bottom:25px;">
                <div id="vAlumniFoto" style="width:90px; height:90px; border-radius:14px; background-size:cover; background-position:center; border:2px solid var(--primary); flex-shrink:0;"></div>
                <div>
                    <h2 id="vAlumniNama" style="font-size:1.3rem; font-weight:800; color:var(--dark); line-height:1.2; margin-bottom:4px;"></h2>
                    <p id="vAlumniKerja" style="font-size:0.88rem; font-weight:700; color:var(--accent); text-transform:uppercase;"></p>
                </div>
            </div>
            <div class="modal-data-strip"><i class="fa-solid fa-calendar-check"></i> <p><b>Status Alumni:</b> Angkatan Kelulusan Tahun <span id="vAlumniLulus"></span></p></div>
            <div id="vAlumniTesti" class="biografi-preview-box"></div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        // --- PREVIEW BANNER SLIDER ---
        document.querySelectorAll('.btn-show-slider').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('vSliderTitle').innerText = this.getAttribute('data-title');
                document.getElementById('vSliderBadge').innerText = this.getAttribute('data-badge') ? this.getAttribute('data-badge') : '-';
                document.getElementById('vSliderLink').innerText = this.getAttribute('data-link') ? this.getAttribute('data-link') : 'Tidak diarahkan kemanapun';
                document.getElementById('vSliderSubtitle').innerText = this.getAttribute('data-subtitle') ? this.getAttribute('data-subtitle') : 'Tidak ada sub-deskripsi.';
                document.getElementById('vSliderImage').style.backgroundImage = `url('${this.getAttribute('data-image')}')`;
                document.getElementById('modalShowSlider').classList.add('active');
            });
        });

        // --- ENGINE EVENT EDIT SLIDER (ANTI-CRASH) ---
        document.querySelectorAll('.btn-edit-slider').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEditSlider').action = `/admin/slider/${id}`;
                document.getElementById('editSliderTitle').value = this.getAttribute('data-title');
                document.getElementById('editSliderBadge').value = this.getAttribute('data-badge');
                document.getElementById('editSliderLink').value = this.getAttribute('data-link');
                document.getElementById('editSliderSubtitle').value = this.getAttribute('data-subtitle');
                document.getElementById('editSliderImagePreview').style.backgroundImage = `url('${this.getAttribute('data-image')}')`;
                document.getElementById('modalEditSlider').classList.add('active');
            });
        });

        // --- LIVE PREVIEW IMAGE READER UNTUK EDIT SLIDER ---
        const imgInputSlider = document.getElementById('editSliderImageInput');
        if(imgInputSlider) {
            imgInputSlider.addEventListener('change', function() {
                const file = this.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => document.getElementById('editSliderImagePreview').style.backgroundImage = `url('${e.target.result}')`;
                    reader.readAsDataURL(file);
                }
            });
        }

        // --- PREVIEW DATA ALUMNI ---
        document.querySelectorAll('.btn-show-alumni').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('vAlumniNama').innerText = this.getAttribute('data-nama');
                document.getElementById('vAlumniKerja').innerText = this.getAttribute('data-kerja');
                document.getElementById('vAlumniLulus').innerText = this.getAttribute('data-lulus');
                document.getElementById('vAlumniTesti').innerHTML = `"${this.getAttribute('data-testi')}"`;
                document.getElementById('vAlumniFoto').style.backgroundImage = `url('${this.getAttribute('data-foto')}')`;
                document.getElementById('modalShowAlumni').classList.add('active');
            });
        });
    });
</script>
@endsection