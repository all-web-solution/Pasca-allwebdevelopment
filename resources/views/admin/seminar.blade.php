@extends('layouts.admin')
@section('title', 'Agenda Seminar - Admin')
@section('page_title', 'Manajemen Event & Kolokium')
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
            <h3><i class="fa-solid fa-calendar-days" style="color:var(--primary)"></i> Daftar Event Seminar</h3>
            <button class="btn-modern" onclick="openModal('modalCreateSeminar')"><i class="fa-solid fa-plus"></i> Tambah Event</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Judul Agenda</th><th>Tanggal</th><th>Tags Search</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($seminars as $s)
                    <tr>
                        <td><strong>{{ Str::limit($s->judul_seminar, 50) }}</strong></td>
                        <td><code>{{ \Carbon\Carbon::parse($s->tanggal_pelaksanaan)->format('d-m-Y') }}</code></td>
                        <td><small>{{ $s->tags_pencarian }}</small></td>
                        <td align="right">
                            <form action="{{ route('admin.seminar.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus seminar ini?')" style="display:inline;">
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
    <div class="admin-modal-overlay" id="modalCreateSeminar">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateSeminar')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-calendar-plus" style="color:var(--primary)"></i> Buat Agenda Event</h3>
            <form action="{{ route('admin.seminar.store') }}" method="POST">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="flex:2;"><label>Judul Event</label><input type="text" name="judul_seminar" required></div><div class="form-input-cell"><label>Tanggal</label><input type="date" name="tanggal_pelaksanaan" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Tags (Pencarian)</label><input type="text" name="tags_pencarian" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi Singkat</label><textarea name="deskripsi_singkat" rows="3" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Terbitkan Event</button>
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