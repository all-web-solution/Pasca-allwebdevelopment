@extends('layouts.admin')
@section('title', 'Dokumentasi Galeri - Admin')
@section('page_title', 'Galeri Kegiatan')
@section('styles')
<style>
    .admin-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; z-index: 2000; opacity: 0; pointer-events: none; transition: var(--transition); }
    .admin-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .admin-modal-window { background: var(--card-bg); border: 1px solid var(--border-color); width: 90%; max-width: 650px; padding: 40px; border-radius: 20px; position: relative; transform: scale(0.94); transition: var(--transition); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15); max-height: 90vh; overflow-y: auto; }
    .admin-modal-overlay.active .admin-modal-window { transform: scale(1); }
    .modal-close-trigger { position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; color: var(--text-muted); width: 36px; height: 36px; background: var(--light); display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .modal-close-trigger:hover { color: #DC2626; transform: rotate(90deg); }
</style>
@endsection
@section('content')
    @if(session('success')) <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script> @endif
    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-camera-retro" style="color:var(--primary)"></i> Kumpulan Album Galeri</h3>
            <button class="btn-modern" onclick="openModal('modalCreateGaleri')"><i class="fa-solid fa-upload"></i> Upload Foto</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Judul Momen</th><th>Thumbnail</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($galeris as $g)
                    <tr>
                        <td><strong>{{ $g->judul }}</strong></td>
                        <td><div style="width: 70px; height: 45px; background: url('{{ asset('uploads/galeri/'.$g->gambar) }}') center/cover; border-radius: 6px;"></div></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-galeri" data-id="{{ $g->id }}" data-judul="{{ $g->judul }}" data-desk="{{ $g->deskripsi }}"><i class="fa-solid fa-pen"></i> Edit</button>
                                <form action="{{ route('admin.galeri.delete', $g->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')" style="display:inline;">
                                    @csrf @method('DELETE') <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- MODAL CREATE -->
    <div class="admin-modal-overlay" id="modalCreateGaleri">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateGaleri')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-upload" style="color:var(--primary)"></i> Upload Media Galeri</h3>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Judul Dokumentasi</label><input type="text" name="judul" required></div><div class="form-input-cell"><label>File Foto</label><input type="file" name="gambar" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi Acara</label><textarea name="deskripsi" rows="2"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Upload Foto</button>
            </form>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="admin-modal-overlay" id="modalEditGaleri">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditGaleri')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen" style="color:var(--primary)"></i> Edit Info Galeri</h3>
            <form id="formEditGaleri" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Judul</label><input type="text" id="editGaleriJudul" name="judul" required></div><div class="form-input-cell"><label>Ganti Foto (Opsional)</label><input type="file" name="gambar"></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi</label><textarea id="editGaleriDesk" name="deskripsi" rows="2"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.btn-edit-galeri').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditGaleri').action = `/admin/galeri/${this.getAttribute('data-id')}`;
            document.getElementById('editGaleriJudul').value = this.getAttribute('data-judul');
            document.getElementById('editGaleriDesk').value = this.getAttribute('data-desk');
            openModal('modalEditGaleri');
        });
    });
</script>
@endsection