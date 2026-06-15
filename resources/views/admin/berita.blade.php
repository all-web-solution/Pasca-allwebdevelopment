@extends('layouts.admin')

@section('title', 'Manajemen Berita - Admin')
@section('page_title', 'Pusat Informasi & Berita Hub')

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
        width: 90%; max-width: 650px; padding: 40px; border-radius: 20px;
        position: relative; transform: scale(0.94); transition: var(--transition);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
    }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    
    .modal-close-trigger { 
        position: absolute; top: 24px; right: 24px; font-size: 1.4rem; 
        cursor: pointer; color: var(--text-muted); width: 36px; height: 36px;
        background: var(--light); display: flex; align-items: center; 
        justify-content: center; border-radius: 50%; transition: var(--transition);
    }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }

    /* --- PREMIUM EDITORIAL VIEW COMPONENT --- */
    .modal-show-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
        background: var(--primary-light); color: var(--primary); font-size: 0.75rem;
        font-weight: 800; border-radius: 30px; letter-spacing: 0.5px; text-transform: uppercase;
        margin-bottom: 20px; border: 1px solid rgba(10, 77, 46, 0.05);
    }
    [data-theme="dark"] .modal-show-badge { color: var(--accent); }

    .modal-news-cover-preview {
        width: 100%; height: 260px; border-radius: 14px; background-size: cover;
        background-position: center; margin-bottom: 24px; border: 1px solid var(--border-color);
        box-shadow: inset 0 0 40px rgba(0,0,0,0.02);
    }

    .news-meta-strip {
        display: flex; gap: 16px; font-size: 0.85rem; color: var(--text-muted);
        margin-bottom: 16px; font-weight: 500; padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }
    .news-meta-strip span { display: flex; align-items: center; gap: 6px; }
    .news-meta-strip i { color: var(--primary); }
    [data-theme="dark"] .news-meta-strip i { color: var(--accent); }

    .news-article-content-box {
        line-height: 1.725; font-size: 0.95rem; color: var(--text-main);
        text-align: justify; max-height: 250px; overflow-y: auto; padding-right: 10px;
    }
    .news-article-content-box::-webkit-scrollbar { width: 5px; }
    .news-article-content-box::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

    /* --- THUMBNAIL LAYOUT --- */
    .table-news-thumbnail {
        width: 60px; height: 45px; border-radius: 6px; background-size: cover;
        background-position: center; border: 1px solid var(--border-color);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* --- ACTION TABULAR BUTTONS --- */
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

    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-newspaper" style="color:var(--primary)"></i> Terbitkan Berita & Pengumuman</h3>
        </div>
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Judul Artikel Berita</label>
                    <input type="text" name="judul" required placeholder="Tulis judul berita...">
                </div>
                <div class="form-input-cell">
                    <label>Kategori Berita</label>
                    <select name="kategori">
                        <option value="akademik">Akademik</option>
                        <option value="pengumuman">Pengumuman</option>
                    </select>
                </div>
            </div>
            <div class="form-flex-row">
                <div class="form-input-cell">
                    <label>Upload Gambar Cover (.jpg / .png / .webp)</label>
                    <input type="file" name="cover">
                </div>
            </div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;">
                    <label>Isi Konten Artikel Lengkap</label>
                    <textarea name="konten" rows="4" required placeholder="Tulis isi berita di sini..."></textarea>
                </div>
                <button type="submit" class="btn-modern">Terbitkan Berita</button>
            </div>
        </form>

        <div class="tabular-view-shell">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">Visual</th>
                        <th>Judul Pemberitaan</th>
                        <th>Kategori</th>
                        <th>Tanggal Post</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $b)
                    <tr>
                        <td align="center">
                            <div class="table-news-thumbnail" style="background-image: url('{{ asset('img/' . ($b->cover ?? 'news1.jpeg')) }}')"></div>
                        </td>
                        <td><strong>{{ Str::limit($b->judul, 60) }}</strong></td>
                        <td><span class="badge-status {{ $b->kategori == 'akademik' ? 'status-success' : 'status-warning' }}">{{ $b->kategori }}</span></td>
                        <td>{{ $b->created_at->format('d/m/Y') }}</td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger show-type btn-show-trigger" 
                                        data-judul="{{ $b->judul }}" 
                                        data-kategori="{{ $b->kategori }}" 
                                        data-tanggal="{{ $b->created_at->format('d M Y') }}" 
                                        data-cover="{{ asset('img/' . ($b->cover ?? 'news1.jpeg')) }}"
                                        data-konten="{{ $b->konten }}">
                                    <i class="fa-solid fa-eye"></i> View
                                </button>
                                
                                <button class="btn-action-trigger edit-type btn-edit-trigger" 
                                        data-id="{{ $b->id }}" 
                                        data-judul="{{ $b->judul }}" 
                                        data-kategori="{{ $b->kategori }}" 
                                        data-cover="{{ asset('img/' . ($b->cover ?? 'news1.jpeg')) }}"
                                        data-konten="{{ $b->konten }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                
                                <form action="{{ route('admin.berita.delete', $b->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" style="display:inline;">
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

    <div class="admin-modal-overlay" id="modalShowBerita">
        <div class="admin-modal-window" style="max-width: 700px;">
            <span class="modal-close-trigger" onclick="closeModal('modalShowBerita')">&times;</span>
            <div class="modal-show-badge"><i class="fa-solid fa-book-open"></i> Jurnalistik Previewer</div>
            <div id="showBeritaCover" class="modal-news-cover-preview"></div>
            <h2 id="showBeritaJudul" style="font-size: 1.45rem; font-weight: 800; letter-spacing: -0.5px; line-height: 1.3; margin-bottom: 14px; color: var(--dark);"></h2>
            <div class="news-meta-strip">
                <span><i class="fa-solid fa-calendar-day"></i> <p id="showBeritaTanggal"></p></span>
                <span>•</span>
                <span><i class="fa-solid fa-folder-open"></i> <p id="showBeritaKategori" style="text-transform: capitalize; font-weight: 700;"></p></span>
            </div>
            <div id="showBeritaKonten" class="news-article-content-box"></div>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditBerita">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditBerita')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Perbarui Artikel Berita</h3>
            <form id="formEditBerita" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex: 3;">
                        <label>Judul Artikel Berita</label>
                        <input type="text" id="editBeritaJudul" name="judul" required>
                    </div>
                    <div class="form-input-cell" style="flex: 1;">
                        <label>Kategori</label>
                        <select id="editBeritaKategori" name="kategori">
                            <option value="akademik">Akademik</option>
                            <option value="pengumuman">Pengumuman</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-flex-row" style="align-items: center; gap: 20px;">
                    <div id="editBeritaCoverPreview" style="width: 100px; height: 75px; border-radius: 8px; background-size: cover; background-position: center; border: 1px solid var(--border-color); flex-shrink: 0;"></div>
                    <div class="form-input-cell">
                        <label>Ganti Gambar Cover (Kosongkan jika tidak diubah)</label>
                        <input type="file" id="editBeritaCoverInput" name="cover" accept="image/*">
                    </div>
                </div>

                <div class="form-flex-row" style="flex-direction:column; gap:15px;">
                    <div class="form-input-cell" style="width:100%;">
                        <label>Isi Konten Berita Lengkap</label>
                        <textarea id="editBeritaKonten" name="konten" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-modern" style="width:fit-content; align-self:flex-end;">Simpan Perubahan</button>
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
        // --- LOGIKA ENGINE VIEW SHOW BERITA (ANTI CRASH ENTER) ---
        document.querySelectorAll('.btn-show-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const judul = this.getAttribute('data-judul');
                const kategori = this.getAttribute('data-kategori');
                const tanggal = this.getAttribute('data-tanggal');
                const cover = this.getAttribute('data-cover');
                const konten = this.getAttribute('data-konten');

                document.getElementById('showBeritaJudul').innerText = judul;
                document.getElementById('showBeritaKategori').innerText = kategori;
                document.getElementById('showBeritaTanggal').innerText = tanggal;
                document.getElementById('showBeritaKonten').innerHTML = konten.replace(/\n/g, '<br>');
                document.getElementById('showBeritaCover').style.backgroundImage = `url('${cover}')`;
                
                document.getElementById('modalShowBerita').classList.add('active');
            });
        });

        // --- LOGIKA ENGINE EDIT BERITA (ANTI CRASH ENTER) ---
        document.querySelectorAll('.btn-edit-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const kategori = this.getAttribute('data-kategori');
                const konten = this.getAttribute('data-konten');
                const cover = this.getAttribute('data-cover');

                document.getElementById('formEditBerita').action = `/admin/berita/${id}`;
                document.getElementById('editBeritaJudul').value = judul;
                document.getElementById('editBeritaKategori').value = kategori;
                document.getElementById('editBeritaKonten').value = konten;
                
                document.getElementById('editBeritaCoverPreview').style.backgroundImage = `url('${cover}')`;
                
                document.getElementById('modalEditBerita').classList.add('active');
            });
        });

        // Live Preview saat memilih file gambar baru di komputer
        const coverInput = document.getElementById('editBeritaCoverInput');
        if(coverInput) {
            coverInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('editBeritaCoverPreview').style.backgroundImage = `url('${e.target.result}')`;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection