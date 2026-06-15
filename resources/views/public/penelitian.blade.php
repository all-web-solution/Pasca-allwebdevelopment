@extends('layouts.public')

@section('title', 'Penelitian - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Variabel Warna Modern Konsisten */
    :root {
        --yellow-accent: #F59E0B;
        --yellow-light: rgba(245, 158, 11, 0.1);
        --primary-light: rgba(10, 77, 46, 0.08);
        --teal-accent: #0D9488;
        --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.05);
        --card-shadow-hover: 0 25px 50px -12px rgba(10, 77, 46, 0.15);
        --radius-lg: 24px;
        --smooth-transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    section { padding: 80px 8% 100px; position: relative; }

    /* ================================================================= */
    /* UI MODERN: STATISTIK COUNTER (KONSISTEN) */
    /* ================================================================= */
    .stats-container { padding: 0 5%; margin-top: -60px; position: relative; z-index: 10; }
    .stats-grid { 
        display: grid; grid-template-columns: repeat(3, 1fr); 
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); 
        border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.8); 
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); overflow: hidden;
    }
    [data-theme="dark"] .stats-grid { background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(255,255,255,0.05); }
    
    .stat-item { 
        padding: 40px 20px; text-align: center; position: relative; display: flex;
        flex-direction: column; align-items: center; justify-content: center; transition: var(--smooth-transition);
    }
    .stat-item:hover { background: rgba(10, 77, 46, 0.02); }
    [data-theme="dark"] .stat-item:hover { background: rgba(255, 255, 255, 0.02); }
    
    .stat-item:not(:last-child)::after {
        content: ''; position: absolute; right: 0; top: 20%; height: 60%; width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.08), transparent);
    }
    [data-theme="dark"] .stat-item:not(:last-child)::after { background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.1), transparent); }
    
    .stat-icon {
        width: 60px; height: 60px; border-radius: 18px; background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 15px; transition: transform 0.4s ease;
    }
    .stat-item:hover .stat-icon { transform: translateY(-5px); background: var(--primary); color: white; }
    
    .stat-item h3 { font-size: 3.2rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; }
    .stat-item p { color: var(--gray); font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    /* ================================================================= */
    /* UI MODERN: HEADER SEKSI GLOBAL */
    /* ================================================================= */
    .section-header-modern { text-align: center; max-width: 700px; margin: 0 auto 50px; }
    .section-header-modern h2 { font-size: 2.8rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 15px; }
    .section-header-modern h2 span { color: var(--yellow-accent); }
    .section-header-modern p { color: var(--gray); font-size: 1.05rem; font-weight: 500; line-height: 1.6; }
    [data-theme="dark"] .section-header-modern h2 { color: #ffffff; }

    .section-header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; flex-wrap: wrap; gap: 20px; }
    .section-header-flex .title-part h2 { font-size: 2.6rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 10px; }
    .section-header-flex .title-part h2 span { color: var(--yellow-accent); }
    .section-header-flex .title-part p { color: var(--gray); font-size: 1.05rem; font-weight: 500; }
    [data-theme="dark"] .section-header-flex .title-part h2 { color: #ffffff; }

    .search-wrapper-inline { width: 100%; max-width: 380px; position: relative; }
    .search-wrapper-inline input {
        width: 100%; padding: 16px 24px 16px 50px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05);
        background: white; color: var(--dark); outline: none; box-shadow: var(--card-shadow); 
        font-size: 0.95rem; transition: var(--smooth-transition);
    }
    .search-wrapper-inline input:focus { border-color: var(--primary); box-shadow: 0 10px 25px rgba(10, 77, 46, 0.1); }
    .search-wrapper-inline i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--gray); font-size: 1.1rem; }

    /* ================================================================= */
    /* UI MODERN: KOMPONEN PROFIL (KIRI TEKS, KANAN GAMBAR) */
    /* ================================================================= */
    .profile-container {
        display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 50px; align-items: center;
        background: #ffffff; border: 1px solid rgba(0,0,0,0.03); padding: 50px; 
        border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
    }
    [data-theme="dark"] .profile-container { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.05); }
    
    .profile-text h3 { font-size: 2rem; font-weight: 800; margin-bottom: 20px; color: var(--primary); line-height: 1.3; }
    [data-theme="dark"] .profile-text h3 { color: var(--yellow-accent); }
    .profile-text p { color: var(--gray); line-height: 1.8; margin-bottom: 16px; text-align: justify; font-size: 1rem; }
    
    .profile-visual {
        position: relative; height: 420px; border-radius: 20px; overflow: hidden;
        box-shadow: 0 20px 40px rgba(10, 77, 46, 0.2); background-size: cover; background-position: center;
        transition: var(--smooth-transition);
    }
    .profile-visual:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(10, 77, 46, 0.3); }
    .profile-overlay {
        position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 77, 46, 0.95), transparent);
        display: flex; align-items: flex-end; padding: 35px; color: white;
    }

    /* ================================================================= */
    /* UI MODERN: AGENDA SEMINAR CARDS */
    /* ================================================================= */
    .seminar-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
    .seminar-card {
        background: #ffffff; padding: 35px; border-radius: var(--radius-lg); transition: var(--smooth-transition); 
        cursor: pointer; box-shadow: var(--card-shadow); border: 1px solid rgba(0,0,0,0.03);
        position: relative; display: flex; flex-direction: column; height: 100%; overflow: hidden; z-index: 1;
    }
    [data-theme="dark"] .seminar-card { background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.05); }
    .seminar-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); border-color: rgba(10, 77, 46, 0.2); }
    
    .seminar-icon {
        width: 60px; height: 60px; background: var(--primary-light); color: var(--primary); 
        display: flex; align-items: center; justify-content: center; border-radius: 16px; margin-bottom: 20px; font-size: 1.4rem; transition: var(--smooth-transition);
    }
    .seminar-card:hover .seminar-icon { background: var(--primary); color: white; transform: rotate(-10deg) scale(1.1); border-radius: 50%; }
    
    .seminar-card h3 { font-size: 1.35rem; font-weight: 800; color: var(--dark); margin-bottom: 10px; line-height: 1.4; transition: color 0.3s ease; }
    .seminar-card:hover h3 { color: var(--primary); }
    [data-theme="dark"] .seminar-card h3 { color: #F8FAFC; }
    
    .seminar-meta { font-size: 0.85rem; color: var(--yellow-accent); font-weight: 700; margin-bottom: 15px; display: inline-block; padding: 6px 14px; background: var(--yellow-light); border-radius: 20px; }
    .seminar-card p { color: var(--gray); font-size: 0.95rem; line-height: 1.6; flex-grow: 1; }

    /* ================================================================= */
    /* UI MODERN: KARYA PUBLIKASI RISET CARDS */
    /* ================================================================= */
    .publikasi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 35px; }
    .pub-card {
        background: #ffffff; border: 1px solid rgba(0,0,0,0.03); border-radius: var(--radius-lg);
        padding: 40px 30px; transition: var(--smooth-transition); box-shadow: var(--card-shadow);
        position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; z-index: 1;
    }
    [data-theme="dark"] .pub-card { background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.05); }
    
    .pub-card::before {
        content: '\f02d'; font-family: 'FontAwesome'; position: absolute; right: -20px; bottom: -30px;
        font-size: 150px; color: rgba(0,0,0,0.02); z-index: -1; transition: var(--smooth-transition);
    }
    [data-theme="dark"] .pub-card::before { color: rgba(255,255,255,0.02); }
    
    .pub-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); border-color: var(--yellow-accent); }
    .pub-card:hover::before { transform: scale(1.1) rotate(-10deg); color: rgba(245, 158, 11, 0.05); }

    .pub-badge {
        display: inline-block; background: var(--primary-light); color: var(--primary);
        padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;
        margin-bottom: 18px; letter-spacing: 0.5px; text-transform: uppercase;
    }
    .pub-card:hover .pub-badge { background: var(--yellow-accent); color: white; }

    .pub-card h3 { font-size: 1.3rem; font-weight: 800; line-height: 1.4; color: var(--dark); margin-bottom: 12px; }
    [data-theme="dark"] .pub-card h3 { color: #F8FAFC; }
    .pub-author { color: var(--gray); font-size: 0.95rem; font-weight: 600; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; }
    .pub-author i { color: var(--primary); }

    .btn-journal-link {
        display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px;
        background: var(--primary); color: white; text-decoration: none;
        border-radius: 50px; font-size: 0.9rem; font-weight: 700; width: fit-content;
        transition: var(--smooth-transition); box-shadow: 0 10px 20px rgba(10, 77, 46, 0.15);
    }
    .btn-journal-link:hover { background: var(--yellow-accent); transform: translateY(-3px); box-shadow: 0 15px 25px rgba(245, 158, 11, 0.25); color: white; }

    /* ================================================================= */
    /* UI MODERN: JURNAL PORTAL TABS */
    /* ================================================================= */
    .news-tabs { display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; flex-wrap: wrap; }
    .tab-btn {
        padding: 12px 28px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05);
        background: #ffffff; color: var(--dark); font-weight: 700; cursor: pointer; transition: var(--smooth-transition); box-shadow: var(--card-shadow);
    }
    .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 10px 20px rgba(10, 77, 46, 0.15); }
    .tab-btn:hover:not(.active) { transform: translateY(-2px); color: var(--primary); }

    .jurnal-card {
        background: #ffffff; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.02); display: flex; flex-direction: column; cursor: pointer; transition: var(--smooth-transition);
        max-width: 400px; margin: 0 auto;
    }
    .jurnal-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); }
    .jurnal-cover { width: 100%; height: 220px; background-size: cover; background-position: center; transition: transform 0.8s ease; }
    .jurnal-card:hover .jurnal-cover { transform: scale(1.05); }
    .jurnal-content { padding: 30px; text-align: center; background: white; position: relative; z-index: 2; }
    
    /* MODAL MODERN */
    .modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); display:flex; align-items:center; justify-content:center; z-index:5000; opacity:0; pointer-events:none; transition: var(--smooth-transition); }
    .modal-overlay.active { opacity:1; pointer-events:auto; }
    .modal-window { background: #ffffff; width: 90%; max-width: 650px; padding: 45px; border-radius: 28px; position: relative; transform: scale(0.9) translateY(20px); transition: var(--smooth-transition); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.3); }
    .modal-overlay.active .modal-window { transform: scale(1) translateY(0); }
    .close-btn { position: absolute; top: 24px; right: 24px; font-size: 1.4rem; cursor: pointer; color: var(--gray); width: 44px; height: 44px; background: var(--light); display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: var(--smooth-transition); }
    .close-btn:hover { color: #EF4444; background: #FEE2E2; transform: rotate(90deg); }

    /* Responsif */
    @media (max-width: 992px) { .profile-container { grid-template-columns: 1fr; } .profile-visual { height: 300px; } }
    @media (max-width: 768px) {
        .stats-container { padding: 0 6%; margin-top: -40px; }
        .stats-grid { grid-template-columns: 1fr; border-radius: 20px; }
        .stat-item { padding: 35px 20px; }
        .stat-item:not(:last-child)::after { right: 20%; top: auto; bottom: 0; height: 1px; width: 60%; background: linear-gradient(to right, transparent, rgba(0,0,0,0.08), transparent); }
        [data-theme="dark"] .stat-item:not(:last-child)::after { background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent); }
        .stat-icon { width: 50px; height: 50px; font-size: 1.3rem; margin-bottom: 12px; }
        .stat-item h3 { font-size: 2.8rem; }
        .search-wrapper-inline { max-width: 100%; margin-top: 15px; }
        section { padding: 60px 5% 80px; }
        .section-header-flex .title-part h2, .section-header-modern h2 { font-size: 2.2rem; }
    }
</style>
@endsection

@section('content')
    <main class="hero" id="home">
        <div class="slide active" style="background: url('{{ asset('uploads/slider/' . ($sliders->first()->image ?? 'bg-iain.jpeg')) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-graduation-cap"></i> Portal Mutu Riset & Jurnal Ilmiah</div>
                <h2>Eksistensi Riset & Jurnal</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Sentralisasi deseminasi publikasi karya tulis ilmiah populer, klaster riset integratif, dan repositori produk pengetahuan dosen-mahasiswa.</p>
                <a href="#publikasi" class="btn-modern">Lihat Karya Ilmiah <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </main>

    <!-- UI STATISTIK BARU DENGAN IKON & WARNA PLUS KUNING -->
    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-book-journal-whills"></i></div>
                <h3 class="counter" data-target="140">0</h3>
                <p>Jurnal Terpublikasi</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                <h3 class="counter" data-target="25">0</h3>
                <p>Seminar Terlaksana</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-microscope"></i></div>
                <h3 class="counter" data-target="45">0</h3>
                <p>Riset Hibah Internal</p>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- SEKSI 1: DEFINISI & ARAH PENELITIAN MODERN -->
    <!-- ================================================================= -->
    <section id="pengertian">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-magnifying-glass-chart" style="margin-right: 4px;"></i> ARAH STRATEGIS
            </div>
            <h2>Eksistensi Riset <span>Academic</span></h2>
            <p>Orientasi dasar dan definisi paradigma penelitian di lingkungan program magister</p>
        </div>
        <div class="profile-container">
            <div class="profile-text">
                <h3>Definisi & Arah Penelitian</h3>
                <p>Penelitian di Pascasarjana IAIN Curup merupakan kegiatan intensional akademik terstruktur yang mengintegrasikan penalaran kritis murni dengan analisis empiris sosiologis kontemporer.</p>
                <p>Sebagai episentrum transformasi mutu, arah penelitian difokuskan pada pemecahan masalah (*problem-solving*) kontekstual dan strategis yang terjadi di lingkup kemasyarakatan modern melalui luaran riset yang terukur.</p>
            </div>
            <div class="profile-visual" style="background-image: url('https://picsum.photos/800/600?random=89');">
                <div class="profile-overlay">
                    <div>
                        <h4 style="font-weight: 800; font-size: 1.4rem; margin-bottom: 4px;">Laboratorium Riset Humaniora & Sosiologi Agama</h4>
                        <p style="font-size: 0.9rem; opacity: 0.9;">Infrastruktur riset kualitatif & kuantitatif modern.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 2: AGENDA SEMINAR (EVENT CARDS) MODERN -->
    <!-- ================================================================= -->
    <section id="seminar" style="background: rgba(241, 245, 249, 0.6);">
        <div class="section-header-flex" style="align-items: center;">
            <div class="title-part">
                <div style="display: inline-block; padding: 6px 14px; background: rgba(13, 148, 136, 0.1); color: var(--teal-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                    <i class="fa-regular fa-calendar-check" style="margin-right: 4px;"></i> JADWAL KEGIATAN
                </div>
                <h2>Agenda Seminar & <span>Kolokium</span></h2>
                <p>Sistem pencarian jadwal agenda deseminasi hasil riset internal pascasarjana</p>
            </div>
            
            <div class="search-wrapper-inline">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="liveSearch" placeholder="Cari tema seminar / kolokium...">
            </div>
        </div>

        <div class="seminar-grid" id="prodiContainer">
            @forelse($seminar as $sem)
            <div class="seminar-card" data-search="{{ $sem->tags_pencarian }}">
                <div class="seminar-icon"><i class="fa-solid fa-users-rectangle"></i></div>
                <h3>{{ $sem->judul_seminar }}</h3>
                <div>
                    <span class="seminar-meta">
                        <i class="fa-solid fa-calendar-days" style="margin-right: 4px;"></i> 
                        {{ \Carbon\Carbon::parse($sem->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <p>{{ $sem->deskripsi_singkat }}</p>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray); background: #ffffff; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
                <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 20px; color: var(--primary); opacity: 0.5;"></i>
                <p style="font-size: 1.1rem;">Belum ada agenda seminar atau kolokium terdekat saat ini.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 3: KARYA PUBLIKASI RISET (JURNAL CARDS) MODERN -->
    <!-- ================================================================= -->
    <section id="publikasi">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-award" style="margin-right: 4px;"></i> PRESTASI AKADEMIK
            </div>
            <h2>Karya Publikasi Riset <span>Dosen & Mahasiswa</span></h2>
            <p>Daftar artikel ilmiah yang telah berhasil menembus indeksasi jurnal nasional dan internasional bergengsi.</p>
        </div>

        <div class="publikasi-grid">
            @forelse($penelitian as $pn)
            <div class="pub-card">
                <div>
                    <span class="pub-badge"><i class="fa-solid fa-bookmark" style="margin-right: 4px;"></i> {{ $pn->jurnal_nama }} ({{ $pn->tahun }})</span>
                    <h3>{{ $pn->judul_riset }}</h3>
                    <div class="pub-author">
                        <i class="fa-solid fa-user-pen"></i> Ditulis oleh: {{ $pn->penulis }}
                    </div>
                </div>
                @if($pn->link_jurnal)
                    <a href="{{ $pn->link_jurnal }}" target="_blank" class="btn-journal-link">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Baca Full PDF
                    </a>
                @endif
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray); background: rgba(241, 245, 249, 0.4); border-radius: var(--radius-lg); border: 1px dashed rgba(0,0,0,0.05);">
                <i class="fa-solid fa-book-open-reader" style="font-size: 3rem; color: var(--yellow-accent); margin-bottom: 20px; opacity: 0.7;"></i>
                <p style="font-size: 1.1rem;">Belum ada data publikasi artikel ilmiah berkala yang dimasukkan ke dalam arsip admin.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 4: E-JURNAL PORTAL -->
    <!-- ================================================================= -->
    <section id="jurnal" style="background: rgba(16, 185, 129, 0.03);">
        <div class="section-header-modern">
            <h2>E-Jurnal Portal <span>Pascasarjana</span></h2>
            <p>Akses repositori terpusat Open Journal System (OJS) ekosistem kampus</p>
        </div>
        
        <div class="news-tabs">
            <button class="tab-btn active" data-tab="all">Semua Jurnal</button>
            <button class="tab-btn" data-tab="tarbiyah">Rumpun Kependidikan</button>
        </div>
        
        <div style="display: flex; justify-content: center;">
            <div class="jurnal-card" data-type="tarbiyah" onclick="viewNews('Jurnal Edukasia Pasca', 'Portal publikasi jurnal riset ilmiah resmi Pascasarjana IAIN Curup yang fokus pada pengembangan model instruksional, manajemen mutu kurikulum madrasah, dan transformasi instansi pendidikan Islam kontemporer di era digital.')">
                <div style="overflow: hidden; width: 100%;">
                    <div class="jurnal-cover" style="background-image: url('https://picsum.photos/600/400?random=21')"></div>
                </div>
                <div class="jurnal-content">
                    <h4 style="font-weight: 800; color: var(--dark); font-size: 1.25rem;">Jurnal Edukasia: Jurnal Penelitian Pendidikan Islam</h4>
                    <span style="display: inline-block; margin-top: 15px; color: var(--primary); font-weight: 700; font-size: 0.9rem;">Lihat Deskripsi <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></span>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL BOX BACA BERITA / JURNAL -->
    <div class="modal-overlay" id="newsModal">
        <div class="modal-window">
            <span class="close-btn" onclick="closeNews()"><i class="fa-solid fa-xmark"></i></span>
            <div style="display: inline-block; padding: 6px 14px; background: var(--yellow-light); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 8px; margin-bottom: 20px; letter-spacing: 0.5px;">DESKRIPSI JURNAL</div>
            <h3 id="mTitle" style="margin-bottom: 25px; color: var(--dark); font-size: 1.6rem; font-weight: 800; line-height: 1.4;"></h3>
            <p id="mBody" style="line-height: 1.8; color: var(--gray); font-size: 1rem; text-align: justify;"></p>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Focus effect form search
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.addEventListener('focus', () => input.style.borderColor = 'var(--primary)');
        input.addEventListener('blur', () => input.style.borderColor = 'rgba(0,0,0,0.05)');
    });

    // Live Search Engine Modul (Untuk Agenda Seminar)
    const liveSearch = document.getElementById('liveSearch');
    liveSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.seminar-card');
        cards.forEach(card => {
            const targetText = card.getAttribute('data-search').toLowerCase();
            card.style.display = targetText.includes(query) ? 'flex' : 'none';
        });
    });

    // Detail Modal Box Engine
    function viewNews(title, body) {
        document.getElementById('mTitle').innerText = title;
        document.getElementById('mBody').innerText = body;
        document.getElementById('newsModal').classList.add('active');
    }
    function closeNews() {
        document.getElementById('newsModal').classList.remove('active');
    }

    // Tab Control Engine
    const tabBtns = document.querySelectorAll('.tab-btn');
    const newsCards = document.querySelectorAll('.jurnal-card');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const targetTab = btn.getAttribute('data-tab');
            newsCards.forEach(card => {
                const type = card.getAttribute('data-type');
                card.style.display = (targetTab === 'all' || type === targetTab) ? 'flex' : 'none';
            });
        });
    });

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
                            c.innerHTML = current > target 
                                ? target + "<span style='color: var(--yellow-accent); margin-left: 4px;'>+</span>" 
                                : current + "<span style='color: var(--yellow-accent); margin-left: 4px;'>+</span>";
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
</script>
@endsection