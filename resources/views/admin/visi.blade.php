@extends('layouts.admin')
@section('title', 'Visi & Latar Belakang - Admin')
@section('page_title', 'Visi Pendidikan')
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
            <h3><i class="fa-solid fa-bullseye" style="color:var(--primary)"></i> Arsip Visi Profil</h3>
            <button class="btn-modern" onclick="openModal('modalCreateVisi')"><i class="fa-solid fa-plus"></i> Tambah Visi</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Judul Visi</th><th>Gambar</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($visiData as $v)
                    <tr>
                        <td><strong>{{ Str::limit($v->judul_visi, 50) }}</strong></td>
                        <td><code>{{ $v->gambar_visi ?? '-' }}</code></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-visi" data-id="{{ $v->id }}" data-judul="{{ $v->judul_visi }}" data-desk="{{ $v->deskripsi_visi }}"><i class="fa-solid fa-pen"></i> Edit</button>
                                <form action="{{ route('admin.visi.delete', $v->id) }}" method="POST" onsubmit="return confirm('Hapus visi ini?')" style="display:inline;">
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
    <div class="admin-modal-overlay" id="modalCreateVisi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateVisi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tambah Visi</h3>
            <form action="{{ route('admin.visi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Judul</label><input type="text" name="judul_visi" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Gambar Banner</label><input type="file" name="gambar_visi"></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi</label><textarea name="deskripsi_visi" rows="4" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Visi</button>
            </form>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="admin-modal-overlay" id="modalEditVisi">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditVisi')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Visi</h3>
            <form id="formEditVisi" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Judul</label><input type="text" id="editVisiJudul" name="judul_visi" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Ganti Gambar</label><input type="file" name="gambar_visi"></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi</label><textarea id="editVisiDesk" name="deskripsi_visi" rows="4" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.btn-edit-visi').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditVisi').action = `/admin/visi/${this.getAttribute('data-id')}`;
            document.getElementById('editVisiJudul').value = this.getAttribute('data-judul');
            document.getElementById('editVisiDesk').value = this.getAttribute('data-desk');
            openModal('modalEditVisi');
        });
    });
</script>
@endsection