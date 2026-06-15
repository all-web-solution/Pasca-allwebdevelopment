@extends('layouts.public')

@section('title', 'Beranda - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Variabel Warna Modern */
    :root {
        --yellow-accent: #F59E0B;
        --yellow-light: rgba(245, 158, 11, 0.1);
        --primary-light: rgba(10, 77, 46, 0.08);
        --teal-accent: #0D9488;
        --card-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        --card-shadow-hover: 0 30px 60px -15px rgba(0,0,0,0.15);
        --radius-lg: 24px;
        --smooth-transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* ================================================================= */
    /* UI MODERN: STATISTIK COUNTER (ANDROID / MOBILE OPTIMIZED) */
    /* ================================================================= */
    .stats-container { padding: 0 5%; margin-top: -60px; position: relative; z-index: 10; }
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        background: rgba(255, 255, 255, 0.95); 
        backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); 
        border-radius: var(--radius-lg); 
        border: 1px solid rgba(255,255,255,0.8); 
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); 
        overflow: hidden;
    }
    [data-theme="dark"] .stats-grid { background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(255,255,255,0.05); }
    
    .stat-item { 
        padding: 40px 20px; text-align: center; position: relative; display: flex;
        flex-direction: column; align-items: center; justify-content: center;
        transition: var(--smooth-transition);
    }
    .stat-item:hover { background: rgba(10, 77, 46, 0.02); }
    [data-theme="dark"] .stat-item:hover { background: rgba(255, 255, 255, 0.02); }
    
    /* Garis Pembatas Vertikal (Desktop) */
    .stat-item:not(:last-child)::after {
        content: ''; position: absolute; right: 0; top: 20%; height: 60%; width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.08), transparent);
    }
    [data-theme="dark"] .stat-item:not(:last-child)::after { background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.1), transparent); }
    
    .stat-icon {
        width: 60px; height: 60px; border-radius: 18px; 
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; 
        font-size: 1.6rem; margin-bottom: 15px; transition: transform 0.4s ease;
    }
    .stat-item:hover .stat-icon { transform: translateY(-5px); background: var(--primary); color: white; }
    
    .stat-item h3 { 
        font-size: 3.2rem; font-weight: 800; color: var(--dark); 
        line-height: 1; margin-bottom: 8px; display: flex; align-items: center; justify-content: center;
    }
    .stat-item p { color: var(--gray); font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    /* ================================================================= */
    /* UI MODERN: HEADER SEKSI GLOBAL */
    /* ================================================================= */
    .section-header-flex {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-bottom: 50px; flex-wrap: wrap; gap: 20px;
    }
    .section-header-flex .title-part h2 {
        font-size: 2.6rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 10px;
    }
    .section-header-flex .title-part h2 span { color: var(--yellow-accent); }
    .section-header-flex .title-part p { color: var(--gray); font-size: 1.05rem; font-weight: 500; }
    
    .btn-view-all {
        background: var(--primary); color: white; padding: 14px 30px; border-radius: 50px;
        font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: var(--smooth-transition);
        display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 10px 20px rgba(10, 77, 46, 0.15);
    }
    .btn-view-all:hover { background: #06311e; transform: translateY(-3px); box-shadow: 0 15px 25px rgba(10, 77, 46, 0.25); color: white; }

    .search-wrapper-inline { width: 100%; max-width: 380px; position: relative; }
    .search-wrapper-inline input {
        width: 100%; padding: 16px 24px 16px 50px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05);
        background: white; color: var(--dark); outline: none; box-shadow: var(--card-shadow); 
        font-size: 0.95rem; transition: var(--smooth-transition);
    }
    .search-wrapper-inline input:focus { border-color: var(--primary); box-shadow: 0 10px 25px rgba(10, 77, 46, 0.1); }
    .search-wrapper-inline i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--gray); font-size: 1.1rem; }

    /* ================================================================= */
    /* UI BARU: PROGRAM STUDI BENTO GRID STYLE */
    /* ================================================================= */
    .prodi-bento-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; grid-auto-rows: minmax(280px, auto); }
    .prodi-bento-card {
        border-radius: var(--radius-lg); padding: 35px; position: relative; overflow: hidden;
        display: flex; flex-direction: column; transition: var(--smooth-transition); cursor: pointer;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04); text-decoration: none;
    }
    .prodi-bento-card:hover { transform: translateY(-8px) scale(1.01); box-shadow: 0 25px 50px rgba(0,0,0,0.1); }

    .bento-span-4 { grid-column: span 4; flex-direction: row; align-items: center; justify-content: space-between; gap: 40px; }
    .bento-span-2 { grid-column: span 2; }
    .bento-span-1 { grid-column: span 1; }

    .theme-green { background: var(--primary); color: white; }
    .theme-yellow { background: var(--yellow-accent); color: var(--dark); }
    .theme-teal { background: var(--teal-accent); color: white; }

    .bento-icon-small {
        width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; margin-bottom: 24px; flex-shrink: 0; transition: transform 0.5s ease;
    }
    .prodi-bento-card:hover .bento-icon-small { transform: rotate(-10deg) scale(1.1); }
    .theme-green .bento-icon-small, .theme-teal .bento-icon-small { background: rgba(255,255,255,0.15); color: white; }
    .theme-yellow .bento-icon-small { background: white; color: var(--yellow-accent); }

    .bento-watermark {
        position: absolute; right: -20px; bottom: -30px; font-size: 200px; line-height: 1; z-index: 0;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .theme-green .bento-watermark, .theme-teal .bento-watermark { color: rgba(255,255,255,0.06); }
    .theme-yellow .bento-watermark { color: rgba(0,0,0,0.05); }
    .prodi-bento-card:hover .bento-watermark { transform: scale(1.15) rotate(-5deg); }

    .bento-content { position: relative; z-index: 1; display: flex; flex-direction: column; flex-grow: 1; }
    .bento-content h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 12px; line-height: 1.3; }
    .bento-span-4 .bento-content h3 { font-size: 1.8rem; }
    .bento-content p { font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px; flex-grow: 1; }
    .theme-green .bento-content p, .theme-teal .bento-content p { color: rgba(255,255,255,0.8); }
    .theme-yellow .bento-content p { color: rgba(15, 23, 42, 0.7); font-weight: 500; }

    .bento-tags { display: flex; gap: 8px; flex-wrap: wrap; margin-top: auto; }
    .bento-tag-item { padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(10px); }
    .theme-green .bento-tag-item, .theme-teal .bento-tag-item { background: rgba(255,255,255,0.2); color: white; }
    .theme-yellow .bento-tag-item { background: rgba(255,255,255,0.6); color: var(--dark); }

    /* ================================================================= */
    /* UI MODERN: BERITA & PENGUMUMAN (MAGAZINE STYLE) */
    /* ================================================================= */
    .news-magazine-grid { display: grid; grid-template-columns: 1.25fr 1fr; gap: 40px; }
    .news-feat-card {
        background: #ffffff; border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--card-shadow); border: 1px solid rgba(0,0,0,0.02);
        transition: var(--smooth-transition); display: flex; flex-direction: column; cursor: pointer;
    }
    .news-feat-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); }
    .img-wrapper-large { width: 100%; height: 350px; overflow: hidden; position: relative; }
    .news-feat-img { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .news-feat-card:hover .news-feat-img { transform: scale(1.08); }
    .badge-label {
        position: absolute; top: 24px; left: 24px; padding: 8px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; z-index: 10; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    .badge-label.green { background: rgba(10, 77, 46, 0.9); color: white; }
    .badge-label.yellow { background: rgba(245, 158, 11, 0.9); color: white; }
    .news-feat-content { padding: 35px; flex-grow: 1; display: flex; flex-direction: column; }
    .news-date { font-size: 0.85rem; color: var(--gray); margin-bottom: 12px; display: block; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .news-feat-content h3 { font-size: 1.6rem; font-weight: 800; line-height: 1.35; margin-bottom: 15px; color: var(--dark); transition: var(--smooth-transition); }
    .news-feat-card:hover .news-feat-content h3 { color: var(--primary); }
    .news-feat-content p { color: var(--gray); font-size: 1rem; line-height: 1.7; margin-bottom: 25px; }

    .news-list-stack { display: flex; flex-direction: column; gap: 24px; }
    .news-list-item {
        display: flex; align-items: center; background: #ffffff; padding: 20px; border-radius: 20px; box-shadow: var(--card-shadow); border: 1px solid rgba(0,0,0,0.02); gap: 24px; transition: var(--smooth-transition); cursor: pointer;
    }
    .news-list-item:hover { transform: translateX(-8px); box-shadow: var(--card-shadow-hover); border-color: var(--primary-light); }
    .news-list-content { flex: 1; }
    .news-list-content .badge-inline {
        display: inline-block; background: var(--primary-light); color: var(--primary); padding: 5px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; margin-bottom: 10px; margin-right: 12px; letter-spacing: 0.5px;
    }
    .news-list-content h4 { font-size: 1.15rem; font-weight: 700; line-height: 1.4; color: var(--dark); transition: color 0.3s ease; }
    .news-list-item:hover .news-list-content h4 { color: var(--primary); }
    .list-img-wrapper { width: 130px; height: 130px; border-radius: 14px; overflow: hidden; flex-shrink: 0; }
    .news-list-thumb { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .news-list-item:hover .news-list-thumb { transform: scale(1.1); }

    .announcement-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 35px; }
    .announce-card {
        background: #ffffff; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--card-shadow); border: 1px solid rgba(0,0,0,0.02); display: flex; flex-direction: column; height: 100%; transition: var(--smooth-transition); cursor: pointer;
    }
    .announce-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); }
    .img-wrapper-medium { width: 100%; height: 240px; overflow: hidden; position: relative; }
    .announce-img { width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .announce-card:hover .announce-img { transform: scale(1.08); }
    .announce-content { padding: 35px; flex-grow: 1; display: flex; flex-direction: column; }
    .announce-content h3 { font-size: 1.35rem; font-weight: 800; line-height: 1.4; margin-bottom: 12px; color: var(--dark); transition: color 0.3s ease; }
    .announce-card:hover .announce-content h3 { color: var(--yellow-accent); }
    .announce-content p { color: var(--gray); font-size: 0.95rem; line-height: 1.7; margin-bottom: 25px; }

    .btn-text-link {
        margin-top: auto; display: inline-flex; align-items: center; gap: 8px; color: var(--primary); font-weight: 800; font-size: 0.95rem; background: transparent; border: none; cursor: pointer; padding: 0; transition: var(--smooth-transition); text-transform: uppercase; letter-spacing: 0.5px;
    }
    .btn-text-link i { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .btn-text-link:hover { color: var(--dark); opacity: 0.8; }
    .btn-text-link:hover i { transform: translateX(6px); }

    .modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); display:flex; align-items:center; justify-content:center; z-index:5000; opacity:0; pointer-events:none; transition: var(--smooth-transition); }
    .modal-overlay.active { opacity:1; pointer-events:auto; }
    .modal-window { background: #ffffff; width: 90%; max-width: 680px; padding: 45px; border-radius: 28px; position: relative; transform: scale(0.9) translateY(20px); transition: var(--smooth-transition); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.3); }
    .modal-overlay.active .modal-window { transform: scale(1) translateY(0); }
    .close-btn { position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; color: var(--gray); width: 44px; height: 44px; background: var(--light); display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: var(--smooth-transition); }
    .close-btn:hover { color: #EF4444; background: #FEE2E2; transform: rotate(90deg); }

    /* ================================================================= */
    /* RESPONSIVE DESIGN UTAMA (ANDROID / MOBILE) */
    /* ================================================================= */
    @media (max-width: 1024px) {
        .prodi-bento-grid { grid-template-columns: repeat(2, 1fr); }
        .bento-span-4, .bento-span-2 { grid-column: span 2; }
        .bento-span-4 { flex-direction: column; align-items: flex-start; gap: 20px; }
        .bento-span-1 { grid-column: span 1; }
    }
    @media (max-width: 992px) { .news-magazine-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        /* Stats Fix Untuk Mobile Android */
        .stats-container { padding: 0 6%; margin-top: -40px; }
        .stats-grid { grid-template-columns: 1fr; border-radius: 20px; }
        .stat-item { padding: 35px 20px; }
        
        /* Ubah Garis Pembatas Vertikal Jadi Horizontal */
        .stat-item:not(:last-child)::after {
            right: 20%; top: auto; bottom: 0; height: 1px; width: 60%;
            background: linear-gradient(to right, transparent, rgba(0,0,0,0.08), transparent);
        }
        [data-theme="dark"] .stat-item:not(:last-child)::after { background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent); }
        
        .stat-icon { width: 50px; height: 50px; font-size: 1.3rem; margin-bottom: 12px; }
        .stat-item h3 { font-size: 2.8rem; }

        .search-wrapper-inline { max-width: 100%; margin-top: 15px; }
        .prodi-bento-grid { grid-template-columns: 1fr; }
        .bento-span-4, .bento-span-2, .bento-span-1 { grid-column: span 1; }
    }
    @media (max-width: 576px) { 
        .news-list-item { flex-direction: column; align-items: flex-start; }
        .list-img-wrapper { width: 100%; height: 220px; }
        .section-header-flex .title-part h2 { font-size: 2rem; }
    }
</style>
@endsection

@section('content')
    <!-- HERO SECTION -->
    <main class="hero" id="home">
        @forelse($sliders as $index => $slide)
        <div class="slide {{ $index === 0 ? 'active' : '' }}" style="background: url('{{ asset('uploads/slider/' . $slide->image) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                @if($slide->badge_text)
                    <div class="badge-hero"><i class="fa-solid fa-graduation-cap"></i> {{ $slide->badge_text }}</div>
                @endif
                <h2>{{ $slide->title }}</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">{{ $slide->subtitle }}</p>
                <a href="{{ $slide->link_url ?? '#prodi' }}" class="btn-modern">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        @empty
        <div class="slide active" style="background: url('{{ asset('img/bg-iain2.jpeg') }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-graduation-cap"></i> Institut Agama Islam Negeri Curup</div>
                <h2>Membangun Generasi Unggul & Islami</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Selamat datang di Pusat Layanan Portal Akademik Transformasi Digital Magister Pascasarjana IAIN Curup.</p>
                <a href="#prodi" class="btn-modern">Jelajahi Prodi <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        @endforelse
    </main>

    <!-- UI STATISTIK BARU DENGAN IKON & WARNA PLUS -->
    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-network-wired"></i></div>
                <h3 class="counter" data-target="8">0</h3>
                <p>Klaster Komparatif S2</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-users-viewfinder"></i></div>
                <h3 class="counter" data-target="450">0</h3>
                <p>Riset Mahasiswa Aktif</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-user-tie"></i></div>
                <h3 class="counter" data-target="35">0</h3>
                <p>Dewan Profesor & Doktor</p>
            </div>
        </div>
    </div>

    <!-- SEKSI PROGRAM STUDI (BENTO GRID APPLE STYLE) -->
    <section id="prodi">
        <div class="section-header-flex" style="align-items: center;">
            <div class="title-part">
                <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                    <i class="fa-solid fa-star" style="margin-right: 4px;"></i> AKREDITASI UNGGUL
                </div>
                <h2>Program Studi & Fasilitas <span>Modern</span></h2>
                <p>Teknologi terkini untuk mendukung perjalanan akademik Anda</p>
            </div>
            
            <div class="search-wrapper-inline">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="liveSearch" placeholder="Cari prodi (misal: PAI, HKI, MPI)...">
            </div>
        </div>

        <div class="prodi-bento-grid" id="prodiContainer">
            @foreach ($prodi as $index => $p)
                @php
                    $themeClass = ''; $spanClass = ''; $mod = $index % 5;
                    if ($mod == 0) { $themeClass = 'theme-green'; $spanClass = 'bento-span-2'; } 
                    elseif ($mod == 1) { $themeClass = 'theme-yellow'; $spanClass = 'bento-span-2'; } 
                    elseif ($mod == 2) { $themeClass = 'theme-teal'; $spanClass = 'bento-span-4'; } 
                    elseif ($mod == 3) { $themeClass = 'theme-yellow'; $spanClass = 'bento-span-1'; } 
                    else { $themeClass = 'theme-green'; $spanClass = 'bento-span-1'; }
                @endphp

                <a href="#" class="prodi-bento-card {{ $themeClass }} {{ $spanClass }}" data-search="{{ $p->search_tags }}" onclick="event.preventDefault(); showToast('Membuka rincian prodi {{ $p->nama }}');">
                    <i class="fa-solid {{ $p->icon }} bento-watermark"></i>
                    <div class="bento-icon-small"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="bento-content">
                        <h3>{{ $p->nama }}</h3>
                        <p>{{ $p->deskripsi }}</p>
                        <div class="bento-tags">
                            @foreach(array_slice(explode(' ', $p->search_tags), 0, 3) as $tag)
                                @if(strlen($tag) > 2)
                                    <span class="bento-tag-item">{{ ucfirst($tag) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
            
            <div id="noProdiAlert" style="display: none; grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray); background: white; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
                <i class="fa-solid fa-magnifying-glass-blur" style="font-size: 3rem; margin-bottom: 20px; color: var(--primary); opacity: 0.5;"></i>
                <p style="font-size: 1.1rem;">Program Studi tidak ditemukan. Silakan gunakan kata kunci yang lain.</p>
            </div>
        </div>
    </section>

    @php
        $beritaAkademik = $berita->where('kategori', 'akademik')->values();
        $beritaPengumuman = $berita->where('kategori', 'pengumuman')->values();
    @endphp

    <!-- SEKSI 1: BERITA TERKINI -->
    <section id="berita" style="background: #F8FAFC;">
        <div class="section-header-flex">
            <div class="title-part">
                <div style="display: inline-block; padding: 6px 14px; background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 18px; letter-spacing: 1px;">
                    <span style="display: inline-block; width: 6px; height: 6px; background: var(--primary); border-radius: 50%; margin-right: 6px; transform: translateY(-1px);"></span> TRENDING NOW
                </div>
                <h2>Berita & Update <span>Terkini</span></h2>
                <p>Informasi dan liputan kegiatan terbaru dari kampus Pascasarjana</p>
            </div>
            <a href="#" class="btn-view-all">Semua Berita <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="news-magazine-grid">
            @if(count($beritaAkademik) > 0)
            <div class="news-feat-card trigger-modal-news" data-judul="{{ $beritaAkademik[0]->judul }}" data-konten="{{ $beritaAkademik[0]->konten }}">
                <div class="img-wrapper-large">
                    <div class="news-feat-img" style="background-image: url('{{ asset('img/' . $beritaAkademik[0]->cover) }}');"></div>
                    <span class="badge-label green">BERITA</span>
                </div>
                <div class="news-feat-content">
                    <span class="news-date">{{ $beritaAkademik[0]->created_at->format('d M Y') }}</span>
                    <h3>{{ $beritaAkademik[0]->judul }}</h3>
                    <p>{{ Str::words(strip_tags($beritaAkademik[0]->konten), 25, '...') }}</p>
                    <button class="btn-text-link">Baca Selengkapnya <i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
            @endif

            <div class="news-list-stack">
                @for($i = 1; $i <= 3; $i++)
                    @if(isset($beritaAkademik[$i]))
                    <div class="news-list-item trigger-modal-news" data-judul="{{ $beritaAkademik[$i]->judul }}" data-konten="{{ $beritaAkademik[$i]->konten }}">
                        <div class="news-list-content">
                            <div>
                                <span class="badge-inline">BERITA</span>
                                <span class="news-date" style="display:inline; font-size:0.8rem;">{{ $beritaAkademik[$i]->created_at->format('d M Y') }}</span>
                            </div>
                            <h4>{{ Str::limit($beritaAkademik[$i]->judul, 65) }}</h4>
                        </div>
                        <div class="list-img-wrapper">
                            <div class="news-list-thumb" style="background-image: url('{{ asset('img/' . $beritaAkademik[$i]->cover) }}');"></div>
                        </div>
                    </div>
                    @endif
                @endfor
                
                @if(count($beritaAkademik) == 0)
                    <div style="text-align: center; color: var(--gray); padding: 40px; background: white; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">Belum ada berita akademik dirilis.</div>
                @endif
            </div>
        </div>
    </section>

    <!-- SEKSI 2: PENGUMUMAN TERBARU -->
    <section id="pengumuman" style="background: rgba(16, 185, 129, 0.03);">
        <div class="section-header-flex">
            <div class="title-part">
                <h2>Pengumuman <span>Terbaru</span></h2>
                <p>Informasi resmi, edaran, dan agenda dari administrasi kampus</p>
            </div>
            <a href="#" class="btn-view-all" style="background: var(--dark);">Semua Pengumuman <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="announcement-grid">
            @forelse($beritaPengumuman->take(3) as $pg)
            <div class="announce-card trigger-modal-news" data-judul="{{ $pg->judul }}" data-konten="{{ $pg->konten }}">
                <div class="img-wrapper-medium">
                    <div class="announce-img" style="background-image: url('{{ asset('img/' . $pg->cover) }}');"></div>
                    <span class="badge-label yellow">PENGUMUMAN</span>
                </div>
                <div class="announce-content">
                    <span class="news-date">{{ $pg->created_at->format('d M Y') }}</span>
                    <h3>{{ Str::limit($pg->judul, 65) }}</h3>
                    <p>{{ Str::words(strip_tags($pg->konten), 18, '...') }}</p>
                    <button class="btn-text-link" style="color: var(--yellow-accent);">Selengkapnya <i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; color: var(--gray); padding: 60px; background: white; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
                <i class="fa-solid fa-bullhorn" style="font-size: 2.5rem; margin-bottom: 20px; color: var(--yellow-accent); opacity: 0.8;"></i>
                <p>Belum ada pengumuman resmi terbaru saat ini.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- SEKSI KONTAK FORM -->
    <section id="contact">
        <div class="section-header">
            <h2>Kanal Komunikasi Instan</h2>
            <p>Hubungi sekretariat administrasi layanan pascasarjana secara langsung</p>
        </div>
        <div style="max-width: 650px; margin: 0 auto;">
            <form id="interactiveForm" style="display: flex; flex-direction: column; gap: 20px; background: white; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); border: 1px solid rgba(0,0,0,0.03);">
                <input type="text" id="senderName" placeholder="Nama Lengkap Anda" style="padding: 18px; border-radius: 12px; border: 1px solid var(--card-border); background: var(--light); color: var(--dark); font-size: 1rem; outline: none; transition: var(--smooth-transition);" required>
                <textarea id="senderMsg" rows="5" placeholder="Tulis rincian pesan atau pertanyaan konsultasi prodi..." style="padding: 18px; border-radius: 12px; border: 1px solid var(--card-border); background: var(--light); color: var(--dark); font-size: 1rem; outline: none; transition: var(--smooth-transition);" required></textarea>
                <button type="submit" class="btn-modern" style="justify-content: center; color: white; background: var(--primary); padding: 18px; font-size: 1.05rem;">Kirim Enkripsi Pesan <i class="fa-solid fa-paper-plane" style="margin-left: 8px;"></i></button>
            </form>
        </div>
    </section>

    <!-- MODAL BOX BACA BERITA -->
    <div class="modal-overlay" id="newsModal">
        <div class="modal-window">
            <span class="close-btn" onclick="closeNews()"><i class="fa-solid fa-xmark"></i></span>
            <div style="display: inline-block; padding: 6px 14px; background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 8px; margin-bottom: 20px; letter-spacing: 0.5px;">ARSIP DIGITAL KAMPUS</div>
            <h3 id="mTitle" style="margin-bottom: 25px; color: var(--dark); font-size: 1.6rem; font-weight: 800; line-height: 1.4;"></h3>
            <div id="mBody" style="line-height: 1.8; color: var(--gray); font-size: 1rem; text-align: justify; max-height: 400px; overflow-y: auto; padding-right: 15px;"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Slider Hero Core Engine
    const slides = document.querySelectorAll('.slide');
    let currentSlideIdx = 0;
    if(slides.length > 1) {
        setInterval(() => {
            slides[currentSlideIdx].classList.remove('active');
            currentSlideIdx = (currentSlideIdx + 1) % slides.length;
            slides[currentSlideIdx].classList.add('active');
        }, 6000);
    }

    // Focus effect form search & contact
    const inputs = document.querySelectorAll('input[type="text"], textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', () => input.style.borderColor = 'var(--primary)');
        input.addEventListener('blur', () => input.style.borderColor = 'var(--card-border)');
    });

    // Live Search Prodi
    const liveSearch = document.getElementById('liveSearch');
    const noProdiAlert = document.getElementById('noProdiAlert');
    
    liveSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.prodi-bento-card');
        let foundCounter = 0;

        cards.forEach(card => {
            const targetText = card.getAttribute('data-search').toLowerCase();
            if(targetText.includes(query)) {
                card.style.display = 'flex';
                foundCounter++;
            } else {
                card.style.display = 'none';
            }
        });
        noProdiAlert.style.display = foundCounter === 0 ? 'block' : 'none';
    });

    // Modal Reader Box Engine
    document.querySelectorAll('.trigger-modal-news').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('mTitle').innerText = this.getAttribute('data-judul');
            document.getElementById('mBody').innerHTML = this.getAttribute('data-konten').replace(/\n/g, '<br>');
            document.getElementById('newsModal').classList.add('active');
        });
    });

    function closeNews() {
        document.getElementById('newsModal').classList.remove('active');
    }

    // ENGINE STATS COUNTER MODERN (Dengan Tanda Plus Kuning)
    const counters = document.querySelectorAll('.counter');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                counters.forEach(c => {
                    const target = +c.getAttribute('data-target');
                    let current = 0;
                    const step = () => {
                        if(current < target) {
                            current += Math.ceil(target / 30);
                            // Menginjeksikan span HTML untuk mewarnai tanda '+' jadi kuning
                            c.innerHTML = current > target ? target + "<span style='color: var(--yellow-accent); margin-left: 4px;'>+</span>" : current + "<span style='color: var(--yellow-accent); margin-left: 4px;'>+</span>";
                            setTimeout(step, 30);
                        }
                    };
                    step();
                });
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.6 });
    
    if(document.getElementById('statsGrid')) {
        observer.observe(document.getElementById('statsGrid'));
    }

    // Form Submit
    document.getElementById('interactiveForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const name = document.getElementById('senderName').value;
        showToast(`Pesan aman dari ${name} berhasil dikirim ke sekretariat.`);
        document.getElementById('interactiveForm').reset();
    });
</script>
@endsection