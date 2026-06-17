@extends('layouts.admin')

@section('title', 'Manajemen Hero Slider - Admin')
@section('page_title', 'Banner Beranda Utama')

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
    @if(session('success'))
        <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script>
    @endif

    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-images" style="color:var(--primary)"></i> Daftar Banner Beranda</h3>
            <button class="btn-modern" onclick="openModal('modalCreateSlider')"><i class="fa-solid fa-plus"></i> Tambah Banner</button>
        </div>

        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Judul Slide</th>
                        <th>Badge Label</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $s)
                    <tr>
                        <td><strong>{{ Str::limit($s->title, 50) }}</strong></td>
                        <td><span class="badge-status status-success">{{ $s->badge_text ?? '-' }}</span></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-slider" 
                                        data-id="{{ $s->id }}" data-title="{{ $s->title }}" 
                                        data-badge="{{ $s->badge_text }}" data-link="{{ $s->link_url }}" 
                                        data-subtitle="{{ $s->subtitle }}">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <form action="{{ route('admin.slider.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')" style="display:inline;">
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

    <div class="admin-modal-overlay" id="modalCreateSlider">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateSlider')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tambah Banner Baru</h3>
            <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Judul Utama</label><input type="text" name="title" required></div>
                    <div class="form-input-cell"><label>Label Badge Atas</label><input type="text" name="badge_text"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Link Tombol Redirect</label><input type="url" name="link_url"></div>
                    <div class="form-input-cell"><label>File Gambar</label><input type="file" name="image" required></div>
                </div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi Sub-Judul</label><textarea name="subtitle" rows="3"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Banner</button>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditSlider">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditSlider')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Banner</h3>
            <form id="formEditSlider" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Judul Utama</label><input type="text" id="editSliderTitle" name="title" required></div>
                    <div class="form-input-cell"><label>Label Badge Atas</label><input type="text" id="editSliderBadge" name="badge_text"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Link Tombol Redirect</label><input type="url" id="editSliderLink" name="link_url"></div>
                    <div class="form-input-cell"><label>Ganti Gambar</label><input type="file" name="image"></div>
                </div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Deskripsi Sub-Judul</label><textarea id="editSliderSubtitle" name="subtitle" rows="3"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.btn-edit-slider').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditSlider').action = `/admin/slider/${this.getAttribute('data-id')}`;
            document.getElementById('editSliderTitle').value = this.getAttribute('data-title');
            document.getElementById('editSliderBadge').value = this.getAttribute('data-badge');
            document.getElementById('editSliderLink').value = this.getAttribute('data-link');
            document.getElementById('editSliderSubtitle').value = this.getAttribute('data-subtitle');
            openModal('modalEditSlider');
        });
    });
</script>
@endsection