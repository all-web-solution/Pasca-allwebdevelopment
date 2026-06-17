@extends('layouts.admin')

@section('title', 'Manajemen Pendidikan & Guru Besar - Admin')
@section('page_title', 'Manajemen Data Akademik')

@section('styles')
<style>
    /* ========================================================================= */
    /* PREMIUM APP MODAL ENGINE STYLE */
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
        width: 90%; max-width: 800px; padding: 40px; border-radius: 20px;
        position: relative; transform: scale(0.94); transition: var(--transition);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15); max-height: 90vh; overflow-y: auto;
    }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    
    .modal-close-trigger { 
        position: absolute; top: 24px; right: 24px; font-size: 1.4rem; 
        cursor: pointer; color: var(--text-muted); width: 36px; height: 36px;
        background: var(--light); display: flex; align-items: center; 
        justify-content: center; border-radius: 50%; transition: var(--transition);
    }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }

    /* --- PREMIUM VIEW LOOKS COMPONENT --- */
    .modal-show-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
        background: var(--primary-light); color: var(--primary); font-size: 0.75rem;
        font-weight: 800; border-radius: 30px; letter-spacing: 0.5px; text-transform: uppercase;
        margin-bottom: 20px; border: 1px solid rgba(10, 77, 46, 0.05);
    }
    [data-theme="dark"] .modal-show-badge { color: var(--accent); }

    .modal-profile-header-layout { display: flex; gap: 24px; align-items: center; margin-bottom: 30px; text-align: left; }
    .modal-avatar-frame {
        width: 100px; height: 100px; border-radius: 18px; background-size: cover;
        background-position: center; border: 4px solid var(--card-bg);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); flex-shrink: 0;
    }
    
    .modal-data-strip {
        background: var(--light); padding: 14px 20px; border-radius: 10px;
        font-size: 0.9rem; margin-bottom: 12px; display: flex; align-items: flex-start; gap: 12px;
        border: 1px solid var(--border-color);
    }
    .modal-data-strip i { color: var(--primary); font-size: 1rem; width: 20px; margin-top: 2px; }
    [data-theme="dark"] .modal-data-strip i { color: var(--accent); }

    .biografi-preview-box {
        background: var(--light); border-left: 4px solid var(--primary);
        padding: 20px; border-radius: 0 12px 12px 0; line-height: 1.6;
        font-size: 0.92rem; text-align: justify; color: var(--text-main);
        margin-top: 15px; border-top: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);
    }
    [data-theme="dark"] .biografi-preview-box { border-left-color: var(--accent); }

    /* --- TABULAR BUTTONS ACTIONS --- */
    .btn-action-trigger.edit-type { color: #D97706; }
    .btn-action-trigger.edit-type:hover { background: #D97706; color: white; border-color: #D97706; }
    .btn-action-trigger.show-type { color: #3B82F6; }
    .btn-action-trigger.show-type:hover { background: #3B82F6; color: white; border-color: #3B82F6; }
    .action-row-buttons { display: flex; gap: 6px; justify-content: flex-end; }

    /* Header Form Section */
    .form-section-title {
        font-size: 0.95rem; font-weight: 800; color: var(--primary); 
        margin: 25px 0 15px; padding-bottom: 8px; border-bottom: 2px dashed var(--border-color);
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    [data-theme="dark"] .form-section-title { color: var(--accent); }
    .form-info-text { font-size: 0.8rem; color: var(--text-muted); margin-top: -10px; margin-bottom: 15px; display: block; font-style: italic; }
</style>
@endsection

@section('content')
    @if(session('success'))
        <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script>
    @endif

    <div class="control-container-card" id="kontrol-visi">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-eye" style="color:var(--primary)"></i> Tambah / Kelola Visi & Profil Pendidikan</h3>
        </div>
        <form action="{{ route('admin.visi.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Judul Visi Transformasi</label>
                    <input type="text" name="judul_visi" required placeholder="Contoh: Visi Transformasi Keilmuan Multidisipliner">
                </div>
                <div class="form-input-cell" style="flex: 1;">
                    <label>Gambar Banner Visi (.jpg / .png / .webp)</label>
                    <input type="file" name="gambar_visi">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Isi Uraian Narasi Visi Lengkap</label>
                    <textarea name="deskripsi_visi" rows="3" required placeholder="Tulis rincian paragraf visi profil pendidikan disini..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Simpan Visi</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Judul Visi</th>
                        <th>File Gambar</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visiData as $v)
                    <tr>
                        <td><strong>{{ Str::limit($v->judul_visi, 50) }}</strong></td>
                        <td><code>{{ $v->gambar_visi ?? 'No Image' }}</code></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-visi" data-judul="{{ $v->judul_visi }}" data-deskripsi="{{ $v->deskripsi_visi }}" data-gambar="{{ asset('img/' . $v->gambar_visi) }}"><i class="fa-solid fa-eye"></i> View</button>
                                <button class="btn-action-trigger edit-type btn-edit-visi" data-id="{{ $v->id }}" data-judul="{{ $v->judul_visi }}" data-deskripsi="{{ $v->deskripsi_visi }}"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.visi.delete', $v->id) }}" method="POST" onsubmit="return confirm('Hapus arsip visi ini?')" style="display:inline;">
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

    <div class="control-container-card" id="kontrol-prodi" style="margin-top: 40px;">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-graduation-cap" style="color:var(--primary)"></i> Tambah Program Studi Magister (Lengkap)</h3>
        </div>
        <form action="{{ route('admin.prodi.store') }}" method="POST" class="panel-form-body">
            @csrf
            
            <div class="form-section-title"><i class="fa-solid fa-id-card"></i> A. Identitas Dasar (Tampil di Beranda)</div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Nama Program Studi</label>
                    <input type="text" name="nama" required placeholder="Contoh: S2 - Pendidikan Agama Islam (PAI)">
                </div>
                <div class="form-input-cell">
                    <label>Icon Kelas (FontAwesome)</label>
                    <select name="icon">
                        <option value="fa-book-quran">fa-book-quran (PAI)</option>
                        <option value="fa-folder-tree">fa-folder-tree (MPI)</option>
                        <option value="fa-scale-unbalanced">fa-scale-unbalanced (HKI)</option>
                        <option value="fa-hand-holding-hand">fa-hand-holding-hand (Bimbingan Konseling)</option>
                        <option value="fa-language">fa-language (Bahasa)</option>
                        <option value="fa-coins">fa-coins (Ekonomi/Keuangan)</option>
                    </select>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Kata Kunci Pencarian (Tags dipisah spasi)</label>
                    <input type="text" name="search_tags" required placeholder="pendidikan agama islam pai tarbiyah">
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>Deskripsi Singkat (Beranda)</label>
                    <textarea name="deskripsi" rows="2" required placeholder="Tulis ringkasan prodi untuk tampilan kartu depan..."></textarea>
                </div>
            </div>

            <div class="form-section-title" style="margin-top: 35px;"><i class="fa-solid fa-layer-group"></i> B. Konten Detail Halaman Prodi (Bisa HTML)</div>
            <span class="form-info-text">*Anda bisa menggunakan sintaks HTML sederhana seperti &lt;p&gt;, &lt;b&gt;, atau &lt;ul&gt;&lt;li&gt; untuk merapikan teks di bawah ini.</span>
            
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>1. Profil Program Studi</label>
                    <textarea name="profil" rows="4" placeholder="Tulis uraian panjang tentang profil prodi..."></textarea>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>2. Visi & Misi Prodi</label>
                    <textarea name="visi_misi" rows="4" placeholder="Tulis visi misi program studi..."></textarea>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>3. Struktur Kurikulum</label>
                    <textarea name="kurikulum" rows="4" placeholder="Tulis struktur kurikulum (SKS, mata kuliah)..."></textarea>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>4. Daftar Tenaga Pengajar (Dosen)</label>
                    <textarea name="dosen" rows="4" placeholder="Tulis daftar dosen pengajar..."></textarea>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell" style="width: 100%;">
                    <label>5. Dokumen Legalitas (Tautan / List)</label>
                    <textarea name="dokumen" rows="4" placeholder="Sematkan tautan download atau daftar dokumen akreditasi..."></textarea>
                </div>
            </div>

            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" class="btn-modern" style="width: 100%; justify-content: center; font-size: 1.1rem; padding: 18px;">Simpan Semua Data Prodi Baru</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        <th>URL Slug</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prodi as $p)
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td><span style="font-size: 0.8rem; color: var(--gray); background: var(--light); padding: 4px 8px; border-radius: 4px;">{{ $p->slug }}</span></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-prodi" 
                                    data-nama="{{ $p->nama }}" data-icon="{{ $p->icon }}" 
                                    data-tags="{{ $p->search_tags }}" data-deskripsi="{{ $p->deskripsi }}"
                                    data-profil="{{ $p->profil }}" data-visi="{{ $p->visi_misi }}"
                                    data-kurikulum="{{ $p->kurikulum }}" data-dosen="{{ $p->dosen }}" data-dokumen="{{ $p->dokumen }}">
                                    <i class="fa-solid fa-eye"></i> Preview
                                </button>
                                
                                <button class="btn-action-trigger edit-type btn-edit-prodi" 
                                    data-id="{{ $p->id }}" data-nama="{{ $p->nama }}" data-icon="{{ $p->icon }}" 
                                    data-tags="{{ $p->search_tags }}" data-deskripsi="{{ $p->deskripsi }}"
                                    data-profil="{{ $p->profil }}" data-visi="{{ $p->visi_misi }}"
                                    data-kurikulum="{{ $p->kurikulum }}" data-dosen="{{ $p->dosen }}" data-dokumen="{{ $p->dokumen }}">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>

                                <form action="{{ route('admin.prodi.delete', $p->id) }}" method="POST" onsubmit="return confirm('Hapus prodi beserta detail konten halamannya secara permanen?')" style="display:inline;">
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

    <div class="control-container-card" id="kontrol-gurubesar" style="margin-top: 40px;">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-user-tie" style="color:var(--primary)"></i> Tambah Dewan Guru Besar / Profesor</h3>
        </div>
        <form action="{{ route('admin.gurubesar.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell" style="flex: 1;">
                    <label>Gelar Depan</label>
                    <input type="text" name="gelar_depan" placeholder="Contoh: Prof. Dr.">
                </div>
                <div class="form-input-cell" style="flex: 3;">
                    <label>Nama Lengkap (Tanpa Gelar)</label>
                    <input type="text" name="nama" required placeholder="Contoh: Ahmad Subarjo">
                </div>
                <div class="form-input-cell" style="flex: 2;">
                    <label>Gelar Belakang</label>
                    <input type="text" name="gelar_belakang" placeholder="Contoh: M.Pd.I.">
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Fokus Bidang Keahlian</label>
                    <input type="text" name="bidang_keahlian" required placeholder="Contoh: Epistemologi Pendidikan Islam">
                </div>
                <div class="form-input-cell">
                    <label>Foto Profil (.jpg / .png)</label>
                    <input type="file" name="foto">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Biografi Singkat / Rekam Jejak Akademik</label>
                    <textarea name="biografi_singkat" rows="3" placeholder="Tulis deskripsi singkat profil..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Simpan Guru Besar</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Nama & Gelar Profesor</th>
                        <th>Bidang Keahlian</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurubesar as $gb)
                    <tr>
                        <td><strong>{{ $gb->gelar_depan }} {{ $gb->nama }}{{ $gb->gelar_belakang ? ', ' . $gb->gelar_belakang : '' }}</strong></td>
                        <td><code style="background-color: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 8px; border-radius: 4px;">{{ $gb->bidang_keahlian }}</code></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-gb" data-gelardepan="{{ $gb->gelar_depan }}" data-nama="{{ $gb->nama }}" data-gelarbelakang="{{ $gb->gelar_belakang }}" data-keahlian="{{ $gb->bidang_keahlian }}" data-biografi="{{ $gb->biografi_singkat }}" data-foto="{{ asset('img/prof/' . $gb->foto) }}"><i class="fa-solid fa-eye"></i> View</button>
                                <button class="btn-action-trigger edit-type btn-edit-gb" data-id="{{ $gb->id }}" data-gelardepan="{{ $gb->gelar_depan }}" data-nama="{{ $gb->nama }}" data-gelarbelakang="{{ $gb->gelar_belakang }}" data-keahlian="{{ $gb->bidang_keahlian }}" data-biografi="{{ $gb->biografi_singkat }}"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.gurubesar.delete', $gb->id) }}" method="POST" onsubmit="return confirm('Hapus data profesor ini?')" style="display:inline;">
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


    <div class="admin-modal-overlay" id="modalShowVisi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalShowVisi')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-bullseye"></i> Kriteria Latar Belakang Institusi</div>
            <div id="showVisiGambar" style="width:100%; height:200px; border-radius:12px; background-size:cover; background-position:center; margin-bottom:20px; border:1px solid var(--border-color);"></div>
            <h2 id="showVisiJudul" style="font-size:1.4rem; font-weight:800; margin-bottom:15px; color:var(--dark);"></h2>
            <div id="showVisiDeskripsi" class="biografi-preview-box" style="border-left-color:var(--accent);"></div>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditVisi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditVisi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Perbarui Judul & Narasi Visi</h3>
            <form id="formEditVisi" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Judul Visi</label>
                        <input type="text" id="editVisiJudul" name="judul_visi" required>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Ganti Gambar Banner Visi (Opsional)</label>
                        <input type="file" name="gambar_visi">
                    </div>
                </div>
                <div class="form-flex-row" style="flex-direction:column; gap:15px;">
                    <div class="form-input-cell" style="width:100%;">
                        <label>Isi Narasi Deskripsi</label>
                        <textarea id="editVisiDeskripsi" name="deskripsi_visi" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-modern" style="width:fit-content; align-self:flex-end;">Perbarui Visi</button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalShowProdi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalShowProdi')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-graduation-cap"></i> Dokumen Ringkasan Prodi</div>
            <h2 id="showProdiNama" style="font-size: 1.5rem; font-weight: 800; margin-bottom: 25px; color: var(--dark);"></h2>
            
            <div class="modal-data-strip"><i class="fa-solid fa-icons"></i><p><b>Icon Class:</b> <code id="showProdiIcon" style="margin-left:8px;"></code></p></div>
            <div class="modal-data-strip"><i class="fa-solid fa-tags"></i><p><b>Tags Index:</b> <code id="showProdiTags" style="margin-left:8px;"></code></p></div>
            
            <div style="margin-top: 25px;">
                <label class="form-section-title" style="margin-bottom: 5px;">A. Deskripsi Pendek (Beranda)</label>
                <p id="showProdiDesc" class="biografi-preview-box" style="margin-top: 0;"></p>
            </div>
            <div style="margin-top: 15px;">
                <label class="form-section-title" style="margin-bottom: 5px;">B. Preview Konten HTML (Halaman Detail)</label>
                <div style="background: var(--light); padding: 15px; border-radius: 8px; font-size: 0.85rem; max-height: 200px; overflow-y: auto; color: var(--gray); border: 1px solid var(--border-color);">
                    <p><b>Profil:</b> <span id="vProdiProfil"></span></p>
                    <hr style="margin: 8px 0; border: 0; border-top: 1px solid rgba(0,0,0,0.05);">
                    <p><b>Visi Misi:</b> <span id="vProdiVisi"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditProdi">
        <div class="admin-modal-window" style="max-width: 800px;">
            <span class="modal-close-trigger" onclick="closeModal('modalEditProdi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Data Lengkap Program Studi</h3>
            <form id="formEditProdi" method="POST">
                @csrf @method('PUT')
                
                <div class="form-section-title"><i class="fa-solid fa-id-card"></i> A. Identitas Dasar (Tampil di Beranda)</div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Nama Program Studi</label>
                        <input type="text" id="editProdiNama" name="nama" required>
                    </div>
                    <div class="form-input-cell">
                        <label>Icon Kelas</label>
                        <select id="editProdiIcon" name="icon">
                            <option value="fa-book-quran">fa-book-quran</option>
                            <option value="fa-folder-tree">fa-folder-tree</option>
                            <option value="fa-scale-unbalanced">fa-scale-unbalanced</option>
                            <option value="fa-hand-holding-hand">fa-hand-holding-hand</option>
                            <option value="fa-language">fa-language</option>
                            <option value="fa-coins">fa-coins</option>
                        </select>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Kata Kunci Pencarian (Tags)</label>
                        <input type="text" id="editProdiTags" name="search_tags" required>
                    </div>
                </div>
                <div class="form-flex-row" style="flex-direction:column; gap:15px;">
                    <div class="form-input-cell" style="width:100%;">
                        <label>Deskripsi Pendek (Untuk Beranda)</label>
                        <textarea id="editProdiDeskripsi" name="deskripsi" rows="2" required></textarea>
                    </div>
                </div>

                <div class="form-section-title" style="margin-top: 25px;"><i class="fa-solid fa-layer-group"></i> B. Konten Detail Halaman Prodi (Bisa HTML)</div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;">
                        <label>1. Profil Program Studi</label>
                        <textarea id="editProdiProfil" name="profil" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;">
                        <label>2. Visi & Misi Prodi</label>
                        <textarea id="editProdiVisi" name="visi_misi" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;">
                        <label>3. Struktur Kurikulum</label>
                        <textarea id="editProdiKurikulum" name="kurikulum" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;">
                        <label>4. Daftar Tenaga Pengajar (Dosen)</label>
                        <textarea id="editProdiDosen" name="dosen" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;">
                        <label>5. Dokumen Legalitas</label>
                        <textarea id="editProdiDokumen" name="dokumen" rows="4"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-modern" style="width:100%; justify-content:center; margin-top:20px;">Simpan Semua Perubahan</button>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalShowGb">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalShowGb')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-id-card"></i> Arsip Profil Guru Besar</div>
            <div class="modal-profile-header-layout">
                <div id="showGbFoto" class="modal-avatar-frame"></div>
                <div>
                    <h2 id="showGbFullNama" style="font-size: 1.4rem; font-weight: 800; margin-bottom: 6px;"></h2>
                    <p id="showGbKeahlian" style="font-size: 0.85rem; font-weight: 700; color: var(--accent); text-transform: uppercase;"></p>
                </div>
            </div>
            <div>
                <label style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted);">Biografi Akademik</label>
                <div id="showGbBiografi" class="biografi-preview-box"></div>
            </div>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditGb">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditGb')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-user-pen" style="color:var(--primary)"></i> Edit Data Dewan Guru Besar</h3>
            <form id="formEditGb" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:1;">
                        <label>Gelar Depan</label>
                        <input type="text" id="editGbGelarDepan" name="gelar_depan">
                    </div>
                    <div class="form-input-cell" style="flex:3;">
                        <label>Nama Lengkap</label>
                        <input type="text" id="editGbNama" name="nama" required>
                    </div>
                    <div class="form-input-cell" style="flex:2;">
                        <label>Gelar Belakang</label>
                        <input type="text" id="editGbGelarBelakang" name="gelar_belakang">
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Fokus Bidang Keahlian</label>
                        <input type="text" id="editGbKeahlian" name="bidang_keahlian" required>
                    </div>
                    <div class="form-input-cell">
                        <label>Ganti Foto Profil (Opsional)</label>
                        <input type="file" name="foto">
                    </div>
                </div>
                <div class="form-flex-row" style="flex-direction:column; gap:15px;">
                    <div class="form-input-cell" style="width:100%;">
                        <label>Biografi Singkat</label>
                        <textarea id="editGbBiografi" name="biografi_singkat" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn-modern" style="width:fit-content; align-self:flex-end;">Simpan Pembaruan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        // --- EVENT EVENT LISTENER FOR VISI ---
        document.querySelectorAll('.btn-show-visi').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('showVisiJudul').innerText = this.getAttribute('data-judul');
                document.getElementById('showVisiDeskripsi').innerHTML = this.getAttribute('data-deskripsi').replace(/\n/g, '<br>');
                document.getElementById('showVisiGambar').style.backgroundImage = `url('${this.getAttribute('data-gambar')}')`;
                document.getElementById('modalShowVisi').classList.add('active');
            });
        });

        document.querySelectorAll('.btn-edit-visi').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEditVisi').action = `/admin/pendidikan/visi/${id}`;
                document.getElementById('editVisiJudul').value = this.getAttribute('data-judul');
                document.getElementById('editVisiDeskripsi').value = this.getAttribute('data-deskripsi');
                document.getElementById('modalEditVisi').classList.add('active');
            });
        });

        // --- EVENT EVENT LISTENER FOR PROGRAM STUDI LENGKAP ---
        document.querySelectorAll('.btn-show-prodi').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('showProdiNama').innerText = this.getAttribute('data-nama');
                document.getElementById('showProdiIcon').innerText = this.getAttribute('data-icon');
                document.getElementById('showProdiTags').innerText = this.getAttribute('data-tags');
                document.getElementById('showProdiDesc').innerText = this.getAttribute('data-deskripsi');
                
                // Set Preview Info
                document.getElementById('vProdiProfil').innerText = this.getAttribute('data-profil') ? this.getAttribute('data-profil').substring(0, 50) + '...' : '(Kosong)';
                document.getElementById('vProdiVisi').innerText = this.getAttribute('data-visi') ? this.getAttribute('data-visi').substring(0, 50) + '...' : '(Kosong)';
                
                document.getElementById('modalShowProdi').classList.add('active');
            });
        });

        document.querySelectorAll('.btn-edit-prodi').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEditProdi').action = `/admin/prodi/${id}`;
                
                // Isi Form Identitas Dasar
                document.getElementById('editProdiNama').value = this.getAttribute('data-nama');
                document.getElementById('editProdiIcon').value = this.getAttribute('data-icon');
                document.getElementById('editProdiTags').value = this.getAttribute('data-tags');
                document.getElementById('editProdiDeskripsi').value = this.getAttribute('data-deskripsi');
                
                // Isi Form Konten HTML
                document.getElementById('editProdiProfil').value = this.getAttribute('data-profil');
                document.getElementById('editProdiVisi').value = this.getAttribute('data-visi');
                document.getElementById('editProdiKurikulum').value = this.getAttribute('data-kurikulum');
                document.getElementById('editProdiDosen').value = this.getAttribute('data-dosen');
                document.getElementById('editProdiDokumen').value = this.getAttribute('data-dokumen');
                
                document.getElementById('modalEditProdi').classList.add('active');
            });
        });

        // --- EVENT EVENT LISTENER FOR GURU BESAR ---
        document.querySelectorAll('.btn-show-gb').forEach(btn => {
            btn.addEventListener('click', function() {
                const gd = this.getAttribute('data-gelardepan');
                const nm = this.getAttribute('data-nama');
                const gb = this.getAttribute('data-gelarbelakang');
                
                document.getElementById('showGbFullNama').innerText = `${gd ? gd + ' ' : ''}${nm}${gb ? ', ' + gb : ''}`;
                document.getElementById('showGbKeahlian').innerText = this.getAttribute('data-keahlian');
                
                const bio = this.getAttribute('data-biografi');
                document.getElementById('showGbBiografi').innerText = bio ? bio : 'Belum ada catatan biografi.';
                document.getElementById('showGbFoto').style.backgroundImage = `url('${this.getAttribute('data-foto')}')`;
                
                document.getElementById('modalShowGb').classList.add('active');
            });
        });

        document.querySelectorAll('.btn-edit-gb').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEditGb').action = `/admin/pendidikan/gurubesar/${id}`;
                document.getElementById('editGbGelarDepan').value = this.getAttribute('data-gelardepan');
                document.getElementById('editGbNama').value = this.getAttribute('data-nama');
                document.getElementById('editGbGelarBelakang').value = this.getAttribute('data-gelarbelakang');
                document.getElementById('editGbKeahlian').value = this.getAttribute('data-keahlian');
                document.getElementById('editGbBiografi').value = this.getAttribute('data-biografi');
                document.getElementById('modalEditGb').classList.add('active');
            });
        });
    });
</script>
@endsection