@extends('layouts.public')

@section('title', 'Alumni - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Variabel Warna Modern Konsisten */
    :root {
        --yellow-accent: #F59E0B;
        --primary-light: rgba(10, 77, 46, 0.08);
        --radius-lg: 24px;
        --smooth-transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* ================================================================= */
    /* UI MODERN: STATISTIK COUNTER (KONSISTEN DENGAN BERANDA) */
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
    /* STYLING BAWAAN HALAMAN ALUMNI */
    /* ================================================================= */
    .action-layout { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 40px; }
    .action-card-btn { display: flex; align-items: center; gap: 15px; padding: 20px 40px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius-lg); text-decoration: none; color: var(--dark); font-weight: 700; font-size: 1.1rem; transition: var(--smooth-transition); box-shadow: 0 10px 30px rgba(0,0,0,0.03); cursor: pointer; }
    .action-card-btn:hover { transform: translateY(-5px); border-color: var(--accent); color: var(--primary); box-shadow: 0 15px 35px rgba(16, 185, 129, 0.15); }
    .action-card-btn i { font-size: 1.4rem; color: var(--accent); }
    
    .gb-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
    .gb-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius-lg); overflow: hidden; transition: var(--smooth-transition); text-align: center; padding: 40px 24px; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); display: flex; flex-direction: column; align-items: center; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
    .gb-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-color: var(--accent); }
    .gb-avatar { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 24px; border: 4px solid var(--light); box-shadow: 0 8px 20px rgba(0,0,0,0.08); background-size: cover; background-position: center; }
    .gb-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 6px; color: var(--dark); }
    .gb-card .nira { font-size: 0.8rem; color: var(--primary); font-weight: 700; margin-bottom: 14px; display: block; text-transform: uppercase; background: var(--primary-light); padding: 4px 12px; border-radius: 20px;}
    .gb-card p { color: var(--gray); font-size: 0.95rem; line-height: 1.6; text-align: center; }

    .profile-container { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 50px; align-items: center; background: var(--card-bg); border: 1px solid var(--card-border); padding: 45px; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.04); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
    .profile-text h3 { font-size: 1.8rem; font-weight: 800; margin-bottom: 20px; color: var(--primary); }
    [data-theme="dark"] .profile-text h3 { color: #ffffff; }
    .profile-text p { color: var(--gray); line-height: 1.8; margin-bottom: 16px; text-align: justify; font-size: 1rem; }
    .profile-visual { position: relative; height: 350px; background: url('https://picsum.photos/800/600?random=94') center/cover no-repeat; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 15px 35px rgba(10, 77, 46, 0.15); }
    .profile-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 77, 46, 0.9), transparent); display: flex; align-items: flex-end; padding: 35px; color: white; }

    /* Responsif Mobile Khusus Stats */
    @media (max-width: 768px) {
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

        .profile-container { grid-template-columns: 1fr; gap: 30px; padding: 30px; }
        .profile-visual { height: 250px; }
    }
</style>
@endsection

@section('content')
    <main class="hero" id="home">
        <div class="slide active" style="background: url('{{ asset('uploads/slider/' . ($sliders->first()->image ?? 'bg-iain2.jpeg')) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-user-graduate"></i> Portal Informasi Jaringan Alumni</div>
                <h2>Sinergi Lulusan Magister</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Ruang rekam jejak, distribusi kontribusi keilmuan, dan ruang sinergi lulusan magister Pascasarjana IAIN Curup.</p>
                <a href="#data-alumni" class="btn-modern">Direktori Alumni <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </main>

    <!-- UI STATISTIK BARU DENGAN IKON & WARNA PLUS KUNING -->
    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <h3 class="counter" data-target="{{ $settings['stat_alumni_total'] ?? '1200' }}">0</h3>
                <p>Alumni Terdata</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-briefcase"></i></div>
                <h3 class="counter" data-target="{{ $settings['stat_alumni_kerja'] ?? '86' }}">0</h3>
                <p>Persentase Serapan Kerja (%)</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-handshake"></i></div>
                <h3 class="counter" data-target="{{ $settings['stat_alumni_mitra'] ?? '32' }}">0</h3>
                <p>Mitra Instansi Pengguna</p>
            </div>
        </div>
    </div>

    <section id="pengabdian">
        <div class="section-header">
            <h2>Dedikasi & Pengabdian Masyarakat</h2>
            <p>Manifestasi nyata nilai keilmuan integratif pascasarjana di tengah ruang publik</p>
        </div>
        <div class="profile-container">
            <!-- TEKS DESKRIPSI DINAMIS DARI ADMIN -->
            <div class="profile-text">
                <h3>{{ $settings['alumni_section_title'] ?? 'Kiprah Nyata di Ruang Publik' }}</h3>
                <p>{{ $settings['alumni_section_desc'] ?? 'Alumni Pascasarjana IAIN Curup berkomitmen mengaktualisasikan keilmuan sosiologis religius melalui berbagai bentuk pengabdian transformatif yang adaptif terhadap dinamika zaman. Kurikulum berbasis riset mendalam membekali para lulusan untuk menjadi problem solver di berbagai sektor krusial kemasyarakatan.' }}</p>
            </div>
            <div class="profile-visual">
                <div class="profile-overlay">
                    <div>
                        <h4 style="font-weight: 800; font-size: 1.25rem; letter-spacing: -0.5px;">Simposium Tahunan & Ikatan Alumni Magister</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" style="background: rgba(241, 245, 249, 0.4);">
        <div class="section-header">
            <h2>Sistem Informasi Akses Portal</h2>
        </div>
        <div class="action-layout">
            <a href="#" class="action-card-btn" onclick="event.preventDefault(); showToast('Membuka Dashboard Statistik Tracer Study Kampus...');">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Statistik Tracer Study</span>
            </a>
            <a href="#" class="action-card-btn" onclick="event.preventDefault(); showToast('Membuka modul enkripsi pencarian data direktori alumni...');">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cari Data Alumni</span>
            </a>
        </div>
    </section>

    <section id="data-alumni">
        <div class="section-header">
            <h2>Direktori Profil Alumni Berprestasi</h2>
            <p>Testimoni serta rekam karier lulusan terbaik rumpun keilmuan magister</p>
        </div>
        <div class="gb-grid">
            @forelse($alumni as $al)
            <div class="gb-card">
                <div class="gb-avatar" style="background-image: url('{{ $al->foto ? asset('uploads/alumni/' . $al->foto) : asset('img/prof/default-prof.png') }}')"></div>
                <h3>{{ $al->nama }}</h3>
                <span class="nira">Lulusan Angkatan Tahun {{ $al->tahun_lulus }}</span>
                <p style="margin-bottom: 15px; font-weight: 600; color: var(--dark);">
                    <i class="fa-solid fa-briefcase" style="color: var(--accent); margin-right: 6px;"></i>{{ $al->pekerjaan }}
                </p>
                <p style="font-style: italic; color: var(--gray);">"{{ $al->testimoni }}"</p>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray);">
                <i class="fa-solid fa-user-slash" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px; opacity: 0.5;"></i>
                <p>Belum ada data testimoni alumni berkala yang diinput oleh admin eksekutif.</p>
            </div>
            @endforelse
        </div>
    </section>
@endsection

@section('scripts')
<script>
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
                            // Penyesuaian math ceil agar angka muternya stabil
                            current += Math.ceil(target / 40);
                            
                            // Injeksikan tanda + kuning HTML
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