@extends('layouts.admin')

@section('title', 'Manajemen Guru Besar - Admin')
@section('page_title', 'Dewan Guru Besar')

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
            <h3><i class="fa-solid fa-user-tie" style="color:var(--primary)"></i> Daftar Guru Besar</h3>
            <button class="btn-modern" onclick="openModal('modalCreateGb')"><i class="fa-solid fa-plus"></i> Tambah Profil</button>
        </div>

        <div class="tabular-view-shell" style="padding: 20px;">
            <table class="clean-data-table">
                <thead>
                    <tr>
                        <th>Nama & Gelar</th>
                        <th>Bidang Keahlian</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurubesar as $gb)
                    <tr>
                        <td><strong>{{ $gb->gelar_depan }} {{ $gb->nama }}{{ $gb->gelar_belakang ? ', ' . $gb->gelar_belakang : '' }}</strong></td>
                        <td><span class="badge-status status-success">{{ $gb->bidang_keahlian }}</span></td>
                        <td align="right">
                            <div class="action-row-buttons">
                                <button class="btn-action-trigger edit-type btn-edit-gb" 
                                    data-id="{{ $gb->id }}" data-gelardepan="{{ $gb->gelar_depan }}" 
                                    data-nama="{{ $gb->nama }}" data-gelarbelakang="{{ $gb->gelar_belakang }}" 
                                    data-keahlian="{{ $gb->bidang_keahlian }}" data-biografi="{{ $gb->biografi_singkat }}">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <form action="{{ route('admin.gurubesar.delete', $gb->id) }}" method="POST" onsubmit="return confirm('Hapus profil ini?')" style="display:inline;">
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

    <div class="admin-modal-overlay" id="modalCreateGb">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalCreateGb')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-square-plus" style="color:var(--primary)"></i> Tambah Guru Besar</h3>
            <form action="{{ route('admin.gurubesar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-flex-row">
                    <div class="form-input-cell"><label>Gelar Depan</label><input type="text" name="gelar_depan"></div>
                    <div class="form-input-cell" style="flex:2;"><label>Nama Lengkap</label><input type="text" name="nama" required></div>
                    <div class="form-input-cell"><label>Gelar Belakang</label><input type="text" name="gelar_belakang"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Bidang Keahlian</label><input type="text" name="bidang_keahlian" required></div>
                    <div class="form-input-cell"><label>Foto</label><input type="file" name="foto"></div>
                </div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Biografi</label><textarea name="biografi_singkat" rows="3"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Profil</button>
            </form>
        </div>
    </div>

    <div class="admin-modal-overlay" id="modalEditGb">
        <div class="admin-modal-window">
            <span class="modal-close-trigger" onclick="closeModal('modalEditGb')">&times;</span>
            <h3 style="margin-bottom: 25px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit Guru Besar</h3>
            <form id="formEditGb" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-flex-row">
                    <div class="form-input-cell"><label>Gelar Depan</label><input type="text" id="editGbGelarDepan" name="gelar_depan"></div>
                    <div class="form-input-cell" style="flex:2;"><label>Nama Lengkap</label><input type="text" id="editGbNama" name="nama" required></div>
                    <div class="form-input-cell"><label>Gelar Belakang</label><input type="text" id="editGbGelarBelakang" name="gelar_belakang"></div>
                </div>
                <div class="form-flex-row">
                    <div class="form-input-cell" style="flex:2;"><label>Bidang Keahlian</label><input type="text" id="editGbKeahlian" name="bidang_keahlian" required></div>
                    <div class="form-input-cell"><label>Ganti Foto</label><input type="file" name="foto"></div>
                </div>
                <div class="form-flex-row"><div class="form-input-cell" style="width:100%;"><label>Biografi</label><textarea id="editGbBiografi" name="biografi_singkat" rows="3"></textarea></div></div>
                <button type="submit" class="btn-modern" style="width:100%; justify-content:center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.btn-edit-gb').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('formEditGb').action = `/admin/gurubesar/${this.getAttribute('data-id')}`;
            document.getElementById('editGbGelarDepan').value = this.getAttribute('data-gelardepan');
            document.getElementById('editGbNama').value = this.getAttribute('data-nama');
            document.getElementById('editGbGelarBelakang').value = this.getAttribute('data-gelarbelakang');
            document.getElementById('editGbKeahlian').value = this.getAttribute('data-keahlian');
            document.getElementById('editGbBiografi').value = this.getAttribute('data-biografi');
            openModal('modalEditGb');
        });
    });
</script>
@endsection