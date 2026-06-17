@extends('layouts.admin')

@section('title', 'Manajemen Berita - Admin')
@section('page_title', 'Publikasi & Pengumuman')

@section('styles')
<style>
    .admin-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; z-index: 2000; opacity: 0; pointer-events: none; transition: var(--transition); }
    .admin-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .admin-modal-window { background: var(--card-bg); border: 1px solid var(--border-color); width: 90%; max-width: 650px; padding: 40px; border-radius: 20px; position: relative; transform: scale(0.94); transition: var(--transition); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15); max-height: 90vh; overflow-y: auto; }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    .modal-close-trigger { position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; color: var(--text-muted); width: 36px; height: 36px; background: var(--light); display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }
    .table-news-thumbnail { width: 60px; height: 45px; border-radius: 6px; background-size: cover; background-position: center; border: 1px solid var(--border-color); }
</style>
@endsection

@section('content')
    @if(session('success'))
        <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script>
    @endif

    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-newspaper" style="color:var(--primary)"></i> Daftar Berita</h3>
            <button class="btn-modern" onclick="openModal('modalCreateBerita')"><i class="fa-solid fa-plus"></i> Tulis Berita</button>
        </div>

        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Cover</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $b)
                    <tr>
                        <td align="center"><div class="table-news-thumbnail" style="background-image: url('{{ asset('img/' . ($b->cover ?? 'news1.jpeg')) }}')"></div></td>
                        <td><strong>{{ Str::limit($b->judul, 60) }}</strong></td>
                        <td><span class="badge-status {{ $b->kategori == 'akademik' ? 'status-success' : 'status-warning' }}">{{ $b->kategori }}</span></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-berita" 
                                        data-id="{{ $b->id }}" data-judul="{{ $b->judul }}" data-kategori="{{ $b->kategori }}" 
                                        data-cover="{{ asset('img/' . ($b->cover ?? 'news1.jpeg')) }}" data-konten="{{ $b->konten }}">
                                    <i class="fa-solid fa-pen"></i> Edit
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

    <div class="admin-modal-overlay" id="modalCreateBerita">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateBerita')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tulis Berita Baru</h3>
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex: 2;">
                        <label>Judul Berita</label><input type="text" name="judul" required>
                    </div>
                    <div class="form-input-cell" style="flex: 1;">
                        <label>Kategori</label>
                        <select name="kategori">
                            <option value="akademik">Akademik</option>
                            <option value="pengumuman">Pengumuman</option>
                        </select>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;"><label>Cover (.jpg / .png)</label><input type="file" name="cover"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;"><label>Konten Lengkap</label><textarea name="konten" rows="5" required></textarea></div>
                </div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Terbitkan Berita</button>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditBerita">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditBerita')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Berita</h3>
            <form id="formEditBerita" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex: 2;">
                        <label>Judul Berita</label><input type="text" id="editBeritaJudul" name="judul" required>
                    </div>
                    <div class="form-input-cell" style="flex: 1;">
                        <label>Kategori</label>
                        <select id="editBeritaKategori" name="kategori">
                            <option value="akademik">Akademik</option>
                            <option value="pengumuman">Pengumuman</option>
                        </select>
                    </div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;"><label>Ganti Cover</label><input type="file" name="cover"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="width: 100%;"><label>Konten Lengkap</label><textarea id="editBeritaKonten" name="konten" rows="5" required></textarea></div>
                </div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.btn-edit-berita').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditBerita').action = `/admin/berita/${this.getAttribute('data-id')}`;
            document.getElementById('editBeritaJudul').value = this.getAttribute('data-judul');
            document.getElementById('editBeritaKategori').value = this.getAttribute('data-kategori');
            document.getElementById('editBeritaKonten').value = this.getAttribute('data-konten');
            openModal('modalEditBerita');
        });
    });
</script>
@endsection