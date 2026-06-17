@extends('layouts.admin')
@section('title', 'Data Alumni - Admin')
@section('page_title', 'Rekam Jejak Alumni')
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
            <h3><i class="fa-solid fa-user-graduate" style="color:var(--primary)"></i> Daftar Testimoni Alumni</h3>
            <button class="btn-modern" onclick="openModal('modalCreateAlumni')"><i class="fa-solid fa-plus"></i> Tambah Alumni</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Nama Alumni</th><th>Tahun Lulus</th><th>Pekerjaan</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($alumnis as $al)
                    <tr>
                        <td><strong>{{ $al->nama }}</strong></td>
                        <td><code>{{ $al->tahun_lulus }}</code></td>
                        <td>{{ $al->pekerjaan }}</td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-alumni" data-id="{{ $al->id }}" data-nama="{{ $al->nama }}" data-lulus="{{ $al->tahun_lulus }}" data-kerja="{{ $al->pekerjaan }}" data-testi="{{ $al->testimoni }}"><i class="fa-solid fa-pen"></i> Edit</button>
                                <form action="{{ route('admin.alumni.delete', $al->id) }}" method="POST" onsubmit="return confirm('Hapus alumni ini?')" style="display:inline;">
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
    <div class="admin-modal-overlay" id="modalCreateAlumni">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateAlumni')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tambah Alumni</h3>
            <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Nama Lengkap</label><input type="text" name="nama" required></div><div class="form-input-cell"><label>Tahun Lulus</label><input type="number" name="tahun_lulus" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Pekerjaan</label><input type="text" name="pekerjaan" required></div><div class="form-input-cell"><label>Foto</label><input type="file" name="foto"></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Testimoni</label><textarea name="testimoni" rows="3" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Alumni</button>
            </form>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="admin-modal-overlay" id="modalEditAlumni">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditAlumni')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Alumni</h3>
            <form id="formEditAlumni" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Nama Lengkap</label><input type="text" id="editAlumniNama" name="nama" required></div><div class="form-input-cell"><label>Tahun Lulus</label><input type="number" id="editAlumniLulus" name="tahun_lulus" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Pekerjaan</label><input type="text" id="editAlumniKerja" name="pekerjaan" required></div><div class="form-input-cell"><label>Ganti Foto</label><input type="file" name="foto"></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Testimoni</label><textarea id="editAlumniTesti" name="testimoni" rows="3" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.btn-edit-alumni').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditAlumni').action = `/admin/alumni/${this.getAttribute('data-id')}`;
            document.getElementById('editAlumniNama').value = this.getAttribute('data-nama');
            document.getElementById('editAlumniLulus').value = this.getAttribute('data-lulus');
            document.getElementById('editAlumniKerja').value = this.getAttribute('data-kerja');
            document.getElementById('editAlumniTesti').value = this.getAttribute('data-testi');
            openModal('modalEditAlumni');
        });
    });
</script>
@endsection