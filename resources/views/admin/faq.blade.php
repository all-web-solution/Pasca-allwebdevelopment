@extends('layouts.admin')
@section('title', 'Manajemen FAQ - Admin')
@section('page_title', 'Kelola Pertanyaan Umum')
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
            <h3><i class="fa-solid fa-circle-question" style="color:var(--primary)"></i> List Pertanyaan Bantuan</h3>
            <button class="btn-modern" onclick="openModal('modalCreateFaq')"><i class="fa-solid fa-plus"></i> Tulis FAQ</button>
        </div>
        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead><tr><th>Teks Pertanyaan</th><th>Jawaban (Preview)</th><th style="text-align: right;">Aksi</th></tr></thead>
                <tbody>
                    @foreach($faqs as $f)
                    <tr>
                        <td><strong>{{ $f->pertanyaan }}</strong></td>
                        <td>{{ Str::limit($f->jawaban, 50) }}</td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-faq" data-id="{{ $f->id }}" data-tanya="{{ $f->pertanyaan }}" data-jawab="{{ $f->jawaban }}"><i class="fa-solid fa-pen"></i> Edit</button>
                                <form action="{{ route('admin.faq.delete', $f->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')" style="display:inline;">
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
    <div class="admin-modal-overlay" id="modalCreateFaq">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateFaq')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-question" style="color:var(--primary)"></i> Buat FAQ Baru</h3>
            <form action="{{ route('admin.faq.store') }}" method="POST">
                @csrf
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Teks Pertanyaan</label><input type="text" name="pertanyaan" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Jawaban Detail</label><textarea name="jawaban" rows="4" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan FAQ</button>
            </form>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="admin-modal-overlay" id="modalEditFaq">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditFaq')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit FAQ</h3>
            <form id="formEditFaq" method="POST">
                @csrf @method('PUT')
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Teks Pertanyaan</label><input type="text" id="editFaqTanya" name="pertanyaan" required></div></div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Jawaban Detail</label><textarea id="editFaqJawab" name="jawaban" rows="4" required></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.btn-edit-faq').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditFaq').action = `/admin/faq/${this.getAttribute('data-id')}`;
            document.getElementById('editFaqTanya').value = this.getAttribute('data-tanya');
            document.getElementById('editFaqJawab').value = this.getAttribute('data-jawab');
            openModal('modalEditFaq');
        });
    });
</script>
@endsection