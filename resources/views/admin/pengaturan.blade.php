@extends('layouts.admin')
@section('title', 'Pengaturan Global - Admin')
@section('page_title', 'Parameter & Pengaturan')

@section('content')
    @if(session('success')) <script>window.addEventListener('load', () => showToast("{{ session('success') }}"))</script> @endif

    <div class="control-container-card">
        <div class="card-panel-heading">
            <h3><i class="fa-solid fa-sliders" style="color:var(--primary)"></i> Pengaturan Statistik & Teks Global</h3>
        </div>
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="panel-form-body">
            @csrf
            <div class="form-flex-row">
                <div class="form-input-cell"><label>Total Alumni (Counter)</label><input type="number" name="stat_alumni_total" value="{{ $settings['stat_alumni_total'] ?? '1200' }}" required></div>
                <div class="form-input-cell"><label>Serapan Kerja (%)</label><input type="number" name="stat_alumni_kerja" value="{{ $settings['stat_alumni_kerja'] ?? '86' }}" required></div>
                <div class="form-input-cell"><label>Mitra Instansi</label><input type="number" name="stat_alumni_mitra" value="{{ $settings['stat_alumni_mitra'] ?? '32' }}" required></div>
            </div>
            <div class="form-flex-row"><div class="form-input-cell" style="width: 100%;"><label>Judul Sub-Seksi Alumni</label><input type="text" name="alumni_section_title" value="{{ $settings['alumni_section_title'] ?? 'Kiprah Nyata di Ruang Publik' }}" required></div></div>
            <div class="form-flex-row" style="align-items: flex-end; margin-bottom:0;">
                <div class="form-input-cell" style="flex: 2;"><label>Deskripsi Blok Alumni</label><textarea name="alumni_section_desc" rows="3" required>{{ $settings['alumni_section_desc'] ?? 'Alumni Pascasarjana IAIN Curup berkomitmen mengaktualisasikan keilmuan...' }}</textarea></div>
                <button type="submit" class="btn-modern">Simpan Parameter</button>
            </div>
        </form>
    </div>
@endsection