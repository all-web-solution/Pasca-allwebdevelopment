@extends('layouts.admin')

@section('title', 'Manajemen Program Studi - Admin')
@section('page_title', 'Program Studi Magister')

@section('styles')
<style>
    .admin-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; z-index: 2000; opacity: 0; pointer-events: none; transition: var(--transition); }
    .admin-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .admin-modal-window { background: var(--card-bg); border: 1px solid var(--border-color); width: 90%; max-width: 800px; padding: 40px; border-radius: 20px; position: relative; transform: scale(0.94); transition: var(--transition); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15); max-height: 90vh; overflow-y: auto; }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    .modal-close-trigger { position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; color: var(--text-muted); width: 36px; height: 36px; background: var(--light); display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }
    .form-section-title { font-size: 0.95rem; font-weight: 800; color: var(--primary); margin: 25px 0 15px; padding-bottom: 8px; border-bottom: 2px dashed var(--border-color); text-transform: uppercase; }
    [data-theme="dark"] .form-section-title { color: var(--accent); }
</style>
@endsection

@section('content')
    @if(session('success'))
        <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script>
    @endif

    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-graduation-cap" style="color:var(--primary)"></i> Daftar Program Studi</h3>
            <button class="btn-modern" onclick="openModal('modalCreateProdi')"><i class="fa-solid fa-plus"></i> Tambah Prodi</button>
        </div>

        <div class="tabular-view-shell" style="padding: 20px;">
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
                        <td><span class="badge-status status-warning">{{ $p->slug }}</span></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-prodi" 
                                    data-id="{{ $p->id }}" data-nama="{{ $p->nama }}" data-icon="{{ $p->icon }}" 
                                    data-tags="{{ $p->search_tags }}" data-deskripsi="{{ $p->deskripsi }}"
                                    data-profil="{{ $p->profil }}" data-visi="{{ $p->visi_misi }}"
                                    data-kurikulum="{{ $p->kurikulum }}" data-dosen="{{ $p->dosen }}" data-dokumen="{{ $p->dokumen }}">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <form action="{{ route('admin.prodi.delete', $p->id) }}" method="POST" onsubmit="return confirm('Hapus permanen prodi ini?')" style="display:inline;">
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

    <div class="admin-modal-overlay" id="modalCreateProdi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateProdi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tambah Prodi Baru</h3>
            <form action="{{ route('admin.prodi.store') }}" method="POST">
                @csrf
                <div class="form-section-title">A. Identitas Dasar</div>
                <div class="form-flex-row">
                    <div class="form-input-cell">
                        <label>Nama Program Studi</label>
                        <input type="text" name="nama" required>
                    </div>
                    <div class="form-input-cell">
                        <label>Icon Kelas</label>
                        <select name="icon">
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
                    <div class="form-input-cell"><label>Kata Kunci (Tags)</label><input type="text" name="search_tags" required></div>
                    <div class="form-input-cell"><label>Deskripsi Singkat</label><input type="text" name="deskripsi" required></div>
                </div>
                <div class="form-section-title">B. Konten Detail Halaman</div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Profil</label><textarea name="profil" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Visi & Misi</label><textarea name="visi_misi" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Kurikulum</label><textarea name="kurikulum" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Dosen</label><textarea name="dosen" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Dokumen</label><textarea name="dokumen" rows="2"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center; margin-top:20px;">Simpan Prodi Baru</button>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditProdi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditProdi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Data Prodi</h3>
            <form id="formEditProdi" method="POST">
                @csrf @method('PUT')
                <div class="form-section-title">A. Identitas Dasar</div>
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
                    <div class="form-input-cell"><label>Kata Kunci (Tags)</label><input type="text" id="editProdiTags" name="search_tags" required></div>
                    <div class="form-input-cell"><label>Deskripsi Singkat</label><input type="text" id="editProdiDeskripsi" name="deskripsi" required></div>
                </div>
                <div class="form-section-title">B. Konten Detail Halaman</div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Profil</label><textarea id="editProdiProfil" name="profil" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Visi & Misi</label><textarea id="editProdiVisi" name="visi_misi" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Kurikulum</label><textarea id="editProdiKurikulum" name="kurikulum" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Dosen</label><textarea id="editProdiDosen" name="dosen" rows="2"></textarea></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Dokumen</label><textarea id="editProdiDokumen" name="dokumen" rows="2"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center; margin-top:20px;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.btn-edit-prodi').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditProdi').action = `/admin/prodi/${this.getAttribute('data-id')}`;
            document.getElementById('editProdiNama').value = this.getAttribute('data-nama');
            document.getElementById('editProdiIcon').value = this.getAttribute('data-icon');
            document.getElementById('editProdiTags').value = this.getAttribute('data-tags');
            document.getElementById('editProdiDeskripsi').value = this.getAttribute('data-deskripsi');
            document.getElementById('editProdiProfil').value = this.getAttribute('data-profil');
            document.getElementById('editProdiVisi').value = this.getAttribute('data-visi');
            document.getElementById('editProdiKurikulum').value = this.getAttribute('data-kurikulum');
            document.getElementById('editProdiDosen').value = this.getAttribute('data-dosen');
            document.getElementById('editProdiDokumen').value = this.getAttribute('data-dokumen');
            openModal('modalEditProdi');
        });
    });
</script>
@endsection