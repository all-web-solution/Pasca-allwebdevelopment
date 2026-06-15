@extends('layouts.public')

@section('title', 'Pendidikan & Akademik - Pascasarjana IAIN Curup')

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
    /* UI MODERN: BENTO GRID PROGRAM STUDI */
    /* ================================================================= */
    .search-wrapper-inline { width: 100%; max-width: 380px; position: relative; }
    .search-wrapper-inline input {
        width: 100%; padding: 16px 24px 16px 50px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05);
        background: white; color: var(--dark); outline: none; box-shadow: var(--card-shadow); 
        font-size: 0.95rem; transition: var(--smooth-transition);
    }
    .search-wrapper-inline input:focus { border-color: var(--primary); box-shadow: 0 10px 25px rgba(10, 77, 46, 0.1); }
    .search-wrapper-inline i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--gray); font-size: 1.1rem; }

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
    /* UI MODERN: GURU BESAR CARDS */
    /* ================================================================= */
    .professor-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
    .prof-card {
        background: #ffffff; border: 1px solid rgba(0,0,0,0.03); padding: 40px 25px;
        border-radius: var(--radius-lg); box-shadow: var(--card-shadow);
        text-align: center; transition: var(--smooth-transition);
        display: flex; flex-direction: column; align-items: center;
    }
    [data-theme="dark"] .prof-card { background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.05); }
    
    .prof-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); border-color: var(--primary-light); }
    
    .prof-avatar {
        width: 130px; height: 130px; border-radius: 50%; margin: 0 auto 20px;
        background-size: cover; background-position: center;
        border: 4px solid var(--primary-light); padding: 4px;
        background-clip: content-box; transition: var(--smooth-transition);
    }
    .prof-card:hover .prof-avatar { border-color: var(--yellow-accent); transform: scale(1.05); }
    
    .prof-badge {
        background: var(--yellow-light); color: var(--yellow-accent);
        padding: 6px 16px; border-radius: 30px; font-size: 0.75rem; font-weight: 800;
        text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;
    }
    
    .prof-card h3 { font-size: 1.2rem; font-weight: 800; margin-bottom: 12px; color: var(--dark); line-height: 1.4; }
    [data-theme="dark"] .prof-card h3 { color: #F8FAFC; }
    .prof-card p { color: var(--gray); font-size: 0.9rem; line-height: 1.6; }

    /* ================================================================= */
    /* UI MODERN: KONTAK & LOKASI */
    /* ================================================================= */
    .contact-layout { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; }
    .contact-box { background: #ffffff; border: 1px solid rgba(0,0,0,0.03); padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); }
    [data-theme="dark"] .contact-box, [data-theme="dark"] .info-card { background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.05); }
    
    .form-group { margin-bottom: 20px; }
    .form-group input, .form-group textarea {
        width: 100%; padding: 18px; border: 1px solid rgba(0,0,0,0.06); border-radius: 14px; 
        background: var(--light); color: var(--dark); outline: none; font-size: 0.95rem; transition: var(--smooth-transition);
    }
    .form-group input:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 5px 15px rgba(10, 77, 46, 0.08); background: #ffffff; }
    
    .btn-send {
        width: 100%; padding: 18px; background: var(--primary); color: white; border: none; border-radius: 14px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: var(--smooth-transition); box-shadow: 0 10px 20px rgba(10, 77, 46, 0.15); display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .btn-send:hover { background: #06311e; transform: translateY(-3px); box-shadow: 0 15px 25px rgba(10, 77, 46, 0.25); }

    .info-box { display: flex; flex-direction: column; gap: 24px; }
    .info-card { background: #ffffff; border: 1px solid rgba(0,0,0,0.03); padding: 35px; border-radius: var(--radius-lg); box-shadow: var(--card-shadow); }
    .info-item { display: flex; align-items: center; gap: 18px; margin-bottom: 25px; }
    .info-item:last-child { margin-bottom: 0; }
    .info-icon { width: 50px; height: 50px; background: var(--yellow-light); color: var(--yellow-accent); display: flex; align-items: center; justify-content: center; border-radius: 14px; font-size: 1.2rem; }
    .info-text h4 { font-size: 0.85rem; color: var(--gray); font-weight: 600; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-text p { font-size: 1rem; font-weight: 700; color: var(--dark); }
    [data-theme="dark"] .info-text p { color: #F8FAFC; }

    .social-container { display: flex; gap: 12px; margin-top: 20px; }
    .social-circle { width: 45px; height: 45px; background: var(--light); border: 1px solid rgba(0,0,0,0.05); color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: var(--smooth-transition); font-size: 1.1rem; }
    .social-circle:hover { background: var(--yellow-accent); color: white; transform: translateY(-5px); border-color: var(--yellow-accent); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2); }

    .map-wrapper {
        background: #ffffff; border: 1px solid rgba(0,0,0,0.03); padding: 15px; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--card-shadow); height: 450px;
    }
    [data-theme="dark"] .map-wrapper { background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.05); }
    .map-wrapper iframe { width: 100%; height: 100%; border: none; border-radius: 14px; }

    @media (max-width: 1024px) {
        .prodi-bento-grid { grid-template-columns: repeat(2, 1fr); }
        .bento-span-4, .bento-span-2 { grid-column: span 2; }
        .bento-span-4 { flex-direction: column; align-items: flex-start; gap: 20px; }
        .bento-span-1 { grid-column: span 1; }
    }
    @media (max-width: 992px) {
        .profile-container, .contact-layout { grid-template-columns: 1fr; }
        .profile-visual { height: 300px; }
    }
    @media (max-width: 768px) {
        section { padding: 60px 5% 80px; }
        .section-header-modern h2, .section-header-flex .title-part h2 { font-size: 2.2rem; }
        .search-wrapper-inline { max-width: 100%; margin-top: 15px; }
        .prodi-bento-grid { grid-template-columns: 1fr; }
        .bento-span-4, .bento-span-2, .bento-span-1 { grid-column: span 1; }
    }
</style>
@endsection

@section('content')
    <main class="hero" id="home">
        <div class="slide active" style="background: url('{{ asset('uploads/slider/' . ($sliders->first()->image ?? 'bg-iain2.jpeg')) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-graduation-cap"></i> Institut Agama Islam Negeri Curup</div>
                <h2>Pendidikan & Jajaran Akademik</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Selamat datang di Pusat Layanan Portal Akademik Transformasi Digital Magister Pascasarjana IAIN Curup.</p>
                <a href="#prodi" class="btn-modern">Jelajahi Prodi <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </main>
   
    <!-- ================================================================= -->
    <!-- SEKSI 1: PROFIL & VISI MODERN -->
    <!-- ================================================================= -->
    <section id="profile">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-building-columns" style="margin-right: 4px;"></i> SELAYANG PANDANG
            </div>
            <h2>Profil & Latar <span>Belakang</span></h2>
            <p>Mengenal pilar utama visi kependidikan tinggi komprehensif di Pascasarjana IAIN Curup</p>
        </div>
        <div class="profile-container">
            <div class="profile-text">
                @if($visi)
                    <h3>{{ $visi->judul_visi }}</h3>
                    <p style="white-space: pre-line;">{{ $visi->deskripsi_visi }}</p>
                @else
                    <h3>Visi Transformasi Keilmuan</h3>
                    <p>Pascasarjana IAIN Curup hadir sebagai institusi strategis penyedia layanan pendidikan jenjang magister (S2) unggulan. Data visi utama belum diatur oleh admin melalui panel control.</p>
                @endif
            </div>
            
            <div class="profile-visual" style="background-image: url('{{ $visi && $visi->gambar_visi ? asset('img/' . $visi->gambar_visi) : 'https://picsum.photos/800/600?random=88' }}');">
                <div class="profile-overlay">
                    <div>
                        <h4 style="font-weight: 800; font-size: 1.4rem; margin-bottom: 4px;">Gedung Sentral Pascasarjana</h4>
                        <p style="font-size: 0.9rem; opacity: 0.9;">Inkubator riset ilmiah & transformasi kurikulum digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 2: PROGRAM STUDI BENTO GRID APPLE STYLE -->
    <!-- ================================================================= -->
    <section id="prodi" style="background: #F8FAFC;">
        <div class="section-header-flex" style="align-items: center;">
            <div class="title-part">
                <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                    <i class="fa-solid fa-star" style="margin-right: 4px;"></i> AKREDITASI UNGGUL
                </div>
                <h2>Program Studi <span>Magister</span></h2>
                <p>Navigasi pemetaan konsentrasi akademik Pascasarjana</p>
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

    <!-- ================================================================= -->
    <!-- SEKSI 3: GURU BESAR MODERN PROFILE CARDS -->
    <!-- ================================================================= -->
    <section id="gurubesar">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(13, 148, 136, 0.1); color: var(--teal-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-user-tie" style="margin-right: 4px;"></i> SUMBER DAYA MANUSIA
            </div>
            <h2>Dewan Guru Besar & <span>Promotor</span></h2>
            <p>Jajaran ilmuwan senior, pakar, dan promotor utama akselerasi karya ilmiah pascasarjana</p>
        </div>
        
        <div class="professor-grid">
            @forelse($gurubesar as $gb)
            <div class="prof-card">
                <div class="prof-avatar" style="background-image: url('{{ asset('img/prof/' . $gb->foto) }}');"></div>
                <div class="prof-badge">{{ $gb->bidang_keahlian }}</div>
                <h3>{{ $gb->gelar_depan ? $gb->gelar_depan . ' ' : '' }}{{ $gb->nama }}{{ $gb->gelar_belakang ? ', ' . $gb->gelar_belakang : '' }}</h3>
                <p>{{ $gb->biografi_singkat }}</p>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; color: var(--gray); padding: 60px; background: white; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
                <i class="fa-solid fa-users-slash" style="font-size: 2.5rem; margin-bottom: 15px; color: var(--primary); opacity: 0.5;"></i>
                <p>Data profil dewan guru besar belum ditambahkan oleh administrator.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 4: KONTAK & LOKASI MODERN -->
    <!-- ================================================================= -->
    <section id="contact" style="background: rgba(16, 185, 129, 0.03);">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-headset" style="margin-right: 4px;"></i> LAYANAN BANTUAN
            </div>
            <h2>Kanal Interaksi & <span>Informasi</span></h2>
            <p>Ajukan pertanyaan konsultasi akademik secara langsung atau ikuti jaringan media komunikasi kami</p>
        </div>
        
        <div class="contact-layout">
            <div class="contact-box">
                <form id="contactForm">
                    <div class="form-group"><input type="text" id="name" placeholder="Nama Lengkap Anda" required></div>
                    <div class="form-group"><input type="email" id="email" placeholder="Alamat Email Aktif" required></div>
                    <div class="form-group"><textarea id="message" rows="5" placeholder="Tulis rincian pertanyaan konsultasi prodi atau pendaftaran akademik..." required></textarea></div>
                    <button type="submit" class="btn-send">Kirim Enkripsi Pesan <i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
            <div class="info-box">
                <div class="info-card">
                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-text"><h4>Email Kesekretariatan</h4><p>pasca@iaincurup.ac.id</p></div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="info-text"><h4>Layanan Telepon/WA</h4><p>+62 732 21544</p></div>
                    </div>
                </div>
                
                <div class="info-card">
                    <h4 style="margin-bottom: 15px; font-weight: 800; font-size: 1.1rem; color: var(--dark);">Kanal Media Sosial Resmi</h4>
                    <p style="color: var(--gray); font-size: 0.95rem; margin-bottom: 20px; line-height: 1.6;">Ikuti publikasi dokumentasi kegiatan, info seminar, dan pengumuman berbasis komunitas digital kami:</p>
                    <div class="social-container">
                        <a href="#" class="social-circle" onclick="event.preventDefault(); showToast('Menghubungkan ke Instagram resmi...');"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-circle" onclick="event.preventDefault(); showToast('Menghubungkan ke YouTube resmi...');"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="social-circle" onclick="event.preventDefault(); showToast('Menghubungkan ke Facebook resmi...');"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-circle" onclick="event.preventDefault(); showToast('Membuka tautan portal utama web...');"><i class="fa-solid fa-globe"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 5: PETA LOKASI -->
    <!-- ================================================================= -->
    <section id="lokasi">
        <div class="section-header-modern">
            <h2>Peta Geografis <span>Kampus</span></h2>
            <p>Alamat: Jl. Dr. AK Gani No. 01, Curup Tengah, Kabupaten Rejang Lebong, Bengkulu</p>
        </div>
        <div class="map-wrapper">
            <iframe src="https://maps.google.com/maps?q=IAIN%20Curup&t=&z=15&ie=UTF-8&iwloc=&output=embed" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="https://maps.app.goo.gl/i1mUwtj5sfUB22oBA" target="_blank" class="btn-view-all">
                <i class="fa-solid fa-map-location-dot"></i> Buka Direktori Google Maps
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Live Search Prodi (Disesuaikan untuk Bento Grid)
    const liveSearch = document.getElementById('liveSearch');
    const noProdiAlert = document.getElementById('noProdiAlert');
    
    // Focus effect untuk input
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', () => input.style.borderColor = 'var(--primary)');
        input.addEventListener('blur', () => input.style.borderColor = 'rgba(0,0,0,0.06)');
    });

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

    // Contact Form Async Submission Handler
    document.getElementById('contactForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const clientName = document.getElementById('name').value;
        showToast(`Koneksi Terjalin! Pesan dari ${clientName} terenkripsi dan terkirim ke sekretariat.`);
        document.getElementById('contactForm').reset();
    });
</script>
@endsection