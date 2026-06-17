@extends('layouts.admin')
@section('title', 'Dokumen - Admin')
@section('page_title', 'Repositori Dokumen')
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
            <h3><i class="fa-solid fa-file-pdf" style="color:var(--primary)"></i> File Dokumen</h3>
            <button class="btn-modern" onclick="openModal('modalCreateDokumen')"><i class="fa-solid fa-upload"></i> Upload Baru</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Nama Dokumen</th><th>Kategori</th><th>Diunduh</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($dokumens as $d)
                    <tr>
                        <td><strong>{{ $d->nama_dokumen }}</strong></td>
                        <td><span class="badge-status status-warning">{{ $d->kategori }}</span></td>
                        <td><strong>{{ $d->download_count }} <i class="fa-solid fa-download"></i></strong></td>
                        <td align="right">
                            <form action="{{ route('admin.dokumen.delete', $d->id) }}" method="POST" onsubmit="return confirm('Hapus permanen file ini?')" style="display:inline;">
                                @csrf @method('DELETE') <button type="submit" class="btn-action-trigger delete-type"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- MODAL UPLOAD -->
    <div class="admin-modal-overlay" id="modalCreateDokumen">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateDokumen')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-upload" style="color:var(--primary)"></i> Upload Berkas</h3>
            <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Nama Dokumen Resmi</label><input type="text" name="nama_dokumen" required></div>
                    <div class="form-input-cell"><label>Kategori</label>
                        <select name="kategori">
                            <option value="Formulir">Formulir</option>
                            <option value="Panduan">Panduan</option>
                            <option value="Kurikulum">Kurikulum</option>
                        </select>
                    </div>
                </div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>File Berkas (.pdf, .doc, dsb)</label><input type="file" name="file_berkas" required></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Upload Dokumen</button>
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