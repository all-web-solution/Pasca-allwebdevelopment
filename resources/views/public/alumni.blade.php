@extends('layouts.public')

@section('title', 'Alumni - Pascasarjana IAIN Curup')

@section('styles')
<style>
    .action-layout { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 40px; }
    .action-card-btn { display: flex; align-items: center; gap: 15px; padding: 20px 40px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); text-decoration: none; color: var(--dark); font-weight: 700; font-size: 1.1rem; transition: var(--transition); box-shadow: 0 8px 16px rgba(0,0,0,0.02); cursor: pointer; }
    .action-card-btn:hover { transform: translateY(-5px); border-color: var(--accent); color: var(--primary); box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15); }
    .action-card-btn i { font-size: 1.4rem; color: var(--accent); }
    
    .gb-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
    .gb-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); overflow: hidden; transition: var(--transition); text-align: center; padding: 40px 24px; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); display: flex; flex-direction: column; align-items: center; }
    .gb-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); border-color: var(--accent); }
    .gb-avatar { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 24px; border: 4px solid var(--light); box-shadow: 0 8px 20px rgba(0,0,0,0.08); background-size: cover; background-position: center; }
    .gb-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 6px; color: var(--dark); }
    .gb-card .nira { font-size: 0.8rem; color: var(--accent); font-weight: 700; margin-bottom: 14px; display: block; text-transform: uppercase; }
    .gb-card p { color: var(--gray); font-size: 0.9rem; line-height: 1.5; text-align: center; }

    .profile-container { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 50px; align-items: center; background: var(--card-bg); border: 1px solid var(--card-border); padding: 45px; border-radius: var(--radius); box-shadow: 0 10px 30px rgba(0,0,0,0.02); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
    .profile-text h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; color: var(--primary); }
    [data-theme="dark"] .profile-text h3 { color: #ffffff; }
    .profile-text p { color: var(--gray); line-height: 1.75; margin-bottom: 16px; text-align: justify; font-size: 0.95rem; }
    .profile-visual { position: relative; height: 320px; background: url('https://picsum.photos/800/600?random=94') center/cover no-repeat; border-radius: var(--radius); overflow: hidden; box-shadow: 0 15px 35px rgba(10, 77, 46, 0.15); }
    .profile-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 77, 46, 0.85), transparent); display: flex; align-items: flex-end; padding: 30px; color: white; }

    @media (max-width: 768px) {
        .profile-container { grid-template-columns: 1fr; gap: 30px; padding: 25px; }
        .profile-visual { height: 220px; }
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

    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item"><h3 class="counter" data-target="1200">0</h3><p>Alumni Terdata</p></div>
            <div class="stat-item"><h3 class="counter" data-target="86">0</h3><p>Persentase Serapan Kerja (%)</p></div>
            <div class="stat-item"><h3 class="counter" data-target="32">0</h3><p>Mitra Instansi Pengguna</p></div>
        </div>
    </div>

    <section id="pengabdian">
        <div class="section-header">
            <h2>Dedikasi & Pengabdian Masyarakat</h2>
            <p>Manifestasi nyata nilai keilmuan integratif pascasarjana di tengah ruang publik</p>
        </div>
        <div class="profile-container">
            <div class="profile-text">
                <h3>Kiprah Nyata di Ruang Publik</h3>
                <p>Alumni Pascasarjana IAIN Curup berkomitmen mengaktualisasikan keilmuan sosiologis religius melalui berbagai bentuk pengabdian transformatif yang adaptif terhadap dinamika zaman.</p>
                <p>Kurikulum berbasis riset mendalam membekali para lulusan untuk menjadi problem solver di berbagai sektor krusial kemasyarakatan.</p>
            </div>
            <div class="profile-visual">
                <div class="profile-overlay">
                    <div>
                        <h4 style="font-weight: 800; font-size: 1.2rem; letter-spacing: -0.5px;">Simposium Tahunan & Ikatan Alumni Magister</h4>
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
                <p style="margin-bottom: 12px; font-weight: 600; color: var(--dark);">
                    <i class="fa-solid fa-briefcase" style="color: var(--accent); margin-right: 6px;"></i>{{ $al->pekerjaan }}
                </p>
                <p style="font-style: italic; color: var(--gray);">"{{ $al->testimoni }}"</p>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray);">
                <i class="fa-solid fa-user-slash" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
                <p>Belum ada data testimoni alumni berkala yang diinput oleh admin eksekutif.</p>
            </div>
            @endforelse
        </div>
    </section>
@endsection

@section('scripts')
<script>
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
                            c.innerText = current > target ? target + "+" : current + "+";
                            setTimeout(step, 30);
                        }
                    };
                    step();
                });
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.6 });
    observer.observe(document.getElementById('statsGrid'));
</script>
@endsection