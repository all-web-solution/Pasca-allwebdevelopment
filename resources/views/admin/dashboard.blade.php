@extends('layouts.admin')

@section('title', 'Dashboard Utama - Admin Pascasarjana')
@section('page_title', 'Ringkasan Eksekutif & Statistik Sistem')

@section('styles')
<style>
    /* ========================================================================= */
    /* ANALYTICS METRIC CARDS SYSTEM */
    /* ========================================================================= */
    .dashboard-analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }
    .metric-visual-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .metric-visual-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
        border-color: var(--accent);
    }
    .metric-info h4 {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 6px;
        font-weight: 700;
    }
    .metric-info h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1;
    }
    .metric-icon-shell {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: var(--transition);
    }
    
    /* Varian Warna Widget Metric */
    .type-prodi .metric-icon-shell { background: rgba(10, 77, 46, 0.08); color: var(--primary); }
    .type-berita .metric-icon-shell { background: rgba(59, 130, 246, 0.08); color: #3B82F6; }
    .type-alumni .metric-icon-shell { background: rgba(245, 158, 11, 0.08); color: #D97706; }
    .type-dokumen .metric-icon-shell { background: rgba(16, 185, 129, 0.08); color: var(--accent); }

    [data-theme="dark"] .metric-icon-shell { background: rgba(255, 255, 255, 0.05) !important; }

    /* ========================================================================= */
    /* TWO COLUMN LAYOUT: QUICK LINKS & LOGS */
    /* ========================================================================= */
    .dashboard-split-layout {
        display: grid;
        grid-template-columns: 1.6fr 1.4fr;
        gap: 30px;
        align-items: flex-start;
    }
    .quick-shortcut-box {
        background: var(--light);
        border: 1px dashed var(--border-color);
        border-radius: var(--radius);
        padding: 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .shortcut-btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        padding: 16px;
        border-radius: 10px;
        text-decoration: none;
        color: var(--text-main);
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: var(--transition);
    }
    .shortcut-btn:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
        transform: translateX(4px);
    }
    [data-theme="dark"] .shortcut-btn:hover { color: var(--accent); border-color: var(--accent); }

    .system-log-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.88rem;
    }
    .system-log-item:last-child { border-bottom: none; }
    .log-meta { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .log-text-box { min-width: 0; }
    .log-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); flex-shrink: 0; }

    @media (max-width: 1200px) {
        .dashboard-analytics-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 992px) {
        .dashboard-split-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 576px) {
        .dashboard-analytics-grid { grid-template-columns: 1fr; }
        .quick-shortcut-box { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="dashboard-analytics-grid">
        
        <div class="metric-visual-card type-prodi">
            <div class="metric-info">
                <h4>Program Studi</h4>
                <h2>{{ $prodi->count() }}</h2>
            </div>
            <div class="metric-icon-shell">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </div>

        <div class="metric-visual-card type-berita">
            <div class="metric-info">
                <h4>Artikel Berita</h4>
                <h2>{{ $berita->count() }}</h2>
            </div>
            <div class="metric-icon-shell">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>

        <div class="metric-visual-card type-alumni">
            <div class="metric-info">
                <h4>Data Alumni</h4>
                <h2>{{ $alumni->count() }}</h2>
            </div>
            <div class="metric-icon-shell">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="metric-visual-card type-dokumen">
            <div class="metric-info">
                <h4>Berkas Akademik</h4>
                <h2>{{ $dokumen->count() }}</h2>
            </div>
            <div class="metric-icon-shell">
                <i class="fa-solid fa-file-arrow-up"></i>
            </div>
        </div>

    </div>

    <div class="dashboard-split-layout">
        
        <div class="control-container-card">
            <div class="card-panel-heading">
                <h3><i class="fa-solid fa-bolt" style="color:#D97706"></i> Gerbang Akses Pintas Modul</h3>
            </div>
            <div class="panel-form-body">
                <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 20px; line-height: 1.5;">Navigasi taktis untuk mengelola form input data publik langsung ke modul spesifik:</p>
                
                <div class="quick-shortcut-box">
                    <a href="{{ route('admin.pendidikan') }}#kontrol-prodi" class="shortcut-btn">
                        <i class="fa-solid fa-circle-plus" style="color:var(--primary)"></i> Input Prodi Baru
                    </a>
                    <a href="{{ route('admin.pendidikan') }}#kontrol-gurubesar" class="shortcut-btn">
                        <i class="fa-solid fa-user-plus" style="color:var(--accent)"></i> Tambah Profesor
                    </a>
                    <a href="{{ route('admin.arsip') }}#kontrol-slider" class="shortcut-btn">
                        <i class="fa-solid fa-images" style="color:#3B82F6"></i> Tambah Banner Hero
                    </a>
                    <a href="{{ route('admin.arsip') }}#kontrol-dokumen" class="shortcut-btn">
                        <i class="fa-solid fa-file-circle-plus" style="color:var(--primary)"></i> Upload Dokumen
                    </a>
                    <a href="{{ route('admin.arsip') }}#kontrol-seminar" class="shortcut-btn">
                        <i class="fa-solid fa-calendar-plus" style="color:#D97706"></i> Agenda Seminar
                    </a>
                    <a href="{{ route('admin.arsip') }}#kontrol-penelitian" class="shortcut-btn">
                        <i class="fa-solid fa-book" style="color:var(--accent)"></i> Arsip Riset Jurnal
                    </a>
                    <a href="{{ route('admin.berita') }}" class="shortcut-btn" style="grid-column: span 2; justify-content: center;">
                        <i class="fa-solid fa-pen-nib" style="color:#3B82F6"></i> Tulis Berita & Pengumuman Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="control-container-card">
            <div class="card-panel-heading">
                <h3><i class="fa-solid fa-clock-rotate-left" style="color:var(--primary)"></i> Aktivitas Terakhir Beranda</h3>
            </div>
            <div class="panel-form-body" style="padding: 10px 30px 30px 30px;">
                
                <div class="system-log-item">
                    <div class="log-meta">
                        <div class="log-dot" style="background:#3B82F6"></div>
                        <div class="log-text-box">
                            <p style="font-weight: 700; color: var(--text-main);">Berita Utama Terkunci</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $berita->first()->judul ?? 'Belum ada data' }}</p>
                        </div>
                    </div>
                    <span class="badge-status status-success" style="font-size: 0.7rem; flex-shrink:0;">Live</span>
                </div>

                <div class="system-log-item">
                    <div class="log-meta">
                        <div class="log-dot" style="background:#D97706"></div>
                        <div class="log-text-box">
                            <p style="font-weight: 700; color: var(--text-main);">Data Rekam Alumni Terbaru</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $alumni->first()->nama ?? 'Belum ada data alumni' }}</p>
                        </div>
                    </div>
                    <span class="badge-status status-success" style="font-size: 0.7rem; flex-shrink:0;">Saved</span>
                </div>

                <div class="system-log-item">
                    <div class="log-meta">
                        <div class="log-dot"></div>
                        <div class="log-text-box">
                            <p style="font-weight: 700; color: var(--text-main);">Koneksi Engine MySQL</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted);">Database: iain-pasca</p>
                        </div>
                    </div>
                    <span class="badge-status status-success" style="font-size: 0.7rem; flex-shrink:0;">Connected</span>
                </div>

                <div class="system-log-item">
                    <div class="log-meta">
                        <div class="log-dot" style="background:#64748B"></div>
                        <div class="log-text-box">
                            <p style="font-weight: 700; color: var(--text-main);">Kerangka Ekosistem</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted);">Laravel v11.x - Production</p>
                        </div>
                    </div>
                    <span class="badge-status" style="background:#e2e8f0; color:#475569; font-size: 0.7rem; flex-shrink:0;">Secure</span>
                </div>

            </div>
        </div>

    </div>
@endsection