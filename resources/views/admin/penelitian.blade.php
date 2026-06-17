@extends('layouts.admin')
@section('title', 'Publikasi Penelitian - Admin')
@section('page_title', 'Arsip Jurnal & Penelitian')
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
            <h3><i class="fa-solid fa-book-bookmark" style="color:var(--primary)"></i> Arsip Penelitian</h3>
            <button class="btn-modern" onclick="openModal('modalCreatePenelitian')"><i class="fa-solid fa-plus"></i> Arsipkan Riset</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Judul Riset</th><th>Penulis</th><th>Media Publikasi</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($penat as $p)
                    <tr>
                        <td><strong>{{ Str::limit($p->judul_riset, 50) }}</strong></td>
                        <td>{{ $p->penulis }}</td>
                        <td><code>{{ $p->jurnal_nama }} ({{ $p->tahun }})</code></td>
                        <td align="right">
                            <form action="{{ route('admin.penelitian.delete', $p->id) }}" method="POST" onsubmit="return confirm('Hapus riset ini?')" style="display:inline;">
                                @csrf @method('DELETE') <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- MODAL CREATE -->
    <div class="admin-modal-overlay" id="modalCreatePenelitian">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreatePenelitian')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-plus" style="color:var(--primary)"></i> Tambah Arsip Riset</h3>
            <form action="{{ route('admin.penelitian.store') }}" method="POST">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="width: 100%;"><label>Judul Riset</label><input type="text" name="judul_riset" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell"><label>Penulis / Tim</label><input type="text" name="penulis" required></div><div class="form-input-cell"><label>Nama Media Jurnal</label><input type="text" name="jurnal_nama" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="flex:1;"><label>Tahun</label><input type="number" name="tahun" required></div><div class="form-input-cell" style="flex:2;"><label>Link URL OJS</label><input type="url" name="link_jurnal"></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Riset</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
</script>
@endsection