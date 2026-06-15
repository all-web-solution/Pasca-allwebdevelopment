@extends('layouts.public')

@section('title', 'Penelitian - Pascasarjana IAIN Curup')

@section('styles')
<style>
    .seminar-meta { font-size: 0.8rem; color: var(--accent); font-weight: 600; margin-top: 5px; display: block; }
    .news-tabs { display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; }
    .tab-btn { padding: 10px 24px; border-radius: 30px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark); font-weight: 600; cursor: pointer; transition: var(--transition); }
    .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    
    .news-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; transition: opacity 0.3s ease; }
    .news-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--card-border); overflow: hidden; transition: var(--transition); cursor: pointer; }
    .news-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); border-color: var(--accent); }
    .news-cover { width: 100%; height: 200px; background-size: cover; background-position: center; }
    .news-content { padding: 24px; }
    
    /* DYNAMIC RESEARCH CARDS LAYOUT */
    .gb-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
    .gb-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); overflow: hidden; transition: var(--transition); padding: 35px 24px; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); display: flex; flex-direction: column; justify-content: space-between; }
    .gb-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); border-color: var(--accent); }
    .gb-card h3 { font-size: 1.15rem; font-weight: 800; line-height: 1.4; color: var(--dark); margin-bottom: 8px; text-align: left; }
    .gb-card .nira { font-size: 0.85rem; color: var(--accent); font-weight: 700; margin-bottom: 15px; display: block; text-transform: uppercase; text-align: left; }
    .gb-card p { color: var(--gray); font-size: 0.9rem; line-height: 1.6; text-align: justify; margin-bottom: 20px; font-style: italic; }
    
    .btn-journal-link { display: inline-flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 700; color: white; background: var(--primary); padding: 8px 18px; border-radius: 6px; text-decoration: none; transition: var(--transition); width: fit-content; }
    .btn-journal-link:hover { background: var(--accent); color: white; transform: translateX(3px); }

    .profile-container { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 50px; align-items: center; background: var(--card-bg); border: 1px solid var(--card-border); padding: 45px; border-radius: var(--radius); box-shadow: 0 10px 30px rgba(0,0,0,0.02); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
    .profile-text h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; color: var(--primary); }
    [data-theme="dark"] .profile-text h3 { color: #ffffff; }
    .profile-text p { color: var(--gray); line-height: 1.75; margin-bottom: 16px; text-align: justify; font-size: 0.95rem; }
    .profile-visual { position: relative; height: 320px; background: url('https://picsum.photos/800/600?random=89') center/cover no-repeat; border-radius: var(--radius); overflow: hidden; box-shadow: 0 15px 35px rgba(10, 77, 46, 0.15); }
    .profile-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 77, 46, 0.85), transparent); display: flex; align-items: flex-end; padding: 30px; color: white; }
    
    .prodi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
    .prodi-card { background: var(--card-bg); border: 1px solid var(--card-border); padding: 32px; border-radius: var(--radius); transition: var(--transition); }
    .prodi-icon { width: 50px; height: 50px; background: rgba(10, 77, 46, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-bottom: 20px; font-size: 1.25rem; }
    
    .modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(2,6,23,0.4); backdrop-filter: blur(8px); display:flex; align-items:center; justify-content:center; z-index:5000; opacity:0; pointer-events:none; transition: var(--transition); }
    .modal-overlay.active { opacity:1; pointer-events:auto; }
    .modal-window { background: var(--card-bg); backdrop-filter: blur(30px); border: 1px solid var(--card-border); width: 90%; max-width: 600px; padding: 40px; border-radius: var(--radius); position: relative; transform: scale(0.9); transition: var(--transition); }
    .modal-overlay.active .modal-window { transform: scale(1); }
    .close-btn { position: absolute; top: 20px; right: 20px; font-size: 1.5rem; cursor: pointer; color: var(--gray); }
    .close-btn:hover { color: #dc2626; }
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

    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item"><h3 class="counter" data-target="140">0</h3><p>Jurnal Terpublikasi</p></div>
            <div class="stat-item"><h3 class="counter" data-target="25">0</h3><p>Seminar Terlaksana</p></div>
            <div class="stat-item"><h3 class="counter" data-target="45">0</h3><p>Riset Hibah Internal</p></div>
        </div>
    </div>

    <section id="pengertian">
        <div class="section-header">
            <h2>Eksistensi Riset Academic</h2>
            <p>Orientasi dasar dan definisi paradigma penelitian di lingkungan program magister</p>
        </div>
        <div class="profile-container">
            <div class="profile-text">
                <h3>Definisi & Arah Penelitian</h3>
                <p>Penelitian di Pascasarjana IAIN Curup merupakan kegiatan intensional akademik terstruktur yang mengintegrasikan penalaran kritis murni dengan analisis empiris sosiologis kontemporer.</p>
                <p>Sebagai episentrum transformasi mutu, arah penelitian difokuskan pada pemecahan masalah (*problem-solving*) kontekstual dan strategis yang terjadi di lingkup kemasyarakatan modern.</p>
            </div>
            <div class="profile-visual">
                <div class="profile-overlay">
                    <div>
                        <h4 style="font-weight: 800; font-size: 1.2rem; letter-spacing: -0.5px;">Laboratorium Riset Humaniora & Sosiologi Agama</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="seminar">
        <div class="section-header">
            <h2>Agenda Seminar & Kolokium</h2>
            <p>Sistem pencarian jadwal agenda deseminasi hasil riset internal pascasarjana</p>
        </div>
        <div class="search-wrapper" style="max-width: 600px; margin: 0 auto 40px;">
            <input type="text" id="liveSearch" placeholder="Ketik kata kunci tema seminar akademik..." style="width: 100%; padding: 16px 24px; border-radius: 30px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark); outline: none;">
        </div>
        <div class="prodi-grid" id="prodiContainer">
            @forelse($seminar as $sem)
            <div class="prodi-card" data-search="{{ $sem->tags_pencarian }}">
                <div class="prodi-icon"><i class="fa-solid fa-users-rectangle"></i></div>
                <h3>{{ $sem->judul_seminar }}</h3>
                <span class="seminar-meta">
                    <i class="fa-solid fa-calendar-days"></i> 
                    {{ \Carbon\Carbon::parse($sem->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                </span>
                <p style="color: var(--gray); font-size: 0.9rem; margin-top: 12px; line-height: 1.5;">{{ $sem->deskripsi_singkat }}</p>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--gray);">
                <i class="fa-solid fa-calendar-xmark" style="font-size: 2rem; margin-bottom: 12px; color: var(--primary);"></i>
                <p>Belum ada agenda seminar atau kolokium terdekat saat ini.</p>
            </div>
            @endforelse
        </div>
    </section>

    <section id="jurnal" style="background: rgba(241, 245, 249, 0.4);">
        <div class="section-header">
            <h2>E-Jurnal Portal Pascasarjana</h2>
            <p>Akses repositori terpusat Open Journal System (OJS) ekosistem kampus</p>
        </div>
        <div class="news-tabs">
            <button class="tab-btn active" data-tab="all">Semua Jurnal</button>
            <button class="tab-btn" data-tab="tarbiyah">Rumpun Kependidikan</button>
        </div>
        <div class="news-grid" id="newsContainer">
            <div class="news-card" data-type="tarbiyah" onclick="viewNews('Jurnal Edukasia Pasca', 'Portal publikasi jurnal riset ilmiah resmi Pascasarjana IAIN Curup yang fokus pada pengembangan model instruksional, manajemen mutu kurikulum madrasah, dan transformasi instansi pendidikan Islam kontemporer di era digital.')">
                <div class="news-cover" style="background-image: url('https://picsum.photos/600/400?random=21')"></div>
                <div class="news-content">
                    <h4 style="font-weight: 700; color: var(--dark); line-height: 1.4;">Jurnal Edukasia: Jurnal Penelitian Pendidikan Islam</h4>
                </div>
            </div>
        </div>
    </section>

    <section id="publikasi">
        <div class="section-header">
            <h2>Karya Publikasi Riset Dosen & Mahasiswa</h2>
            <p>Daftar artikel ilmiah yang telah berhasil menembus indeksasi jurnal nasional dan internasional</p>
        </div>
        <div class="gb-grid">
            @forelse($penelitian as $pn)
            <div class="gb-card">
                <div>
                    <span class="nira"><i class="fa-solid fa-bookmark" style="margin-right: 6px;"></i> {{ $pn->jurnal_nama }} — {{ $pn->tahun }}</span>
                    <h3>{{ $pn->judul_riset }}</h3>
                    <p style="margin-top: 10px; font-weight: 500; color: var(--dark); font-style: normal;">
                        <i class="fa-solid fa-user-pen" style="color: var(--primary); margin-right: 6px; font-size: 0.85rem;"></i> {{ $pn->penulis }}
                    </p>
                </div>
                @if($pn->link_jurnal)
                    <a href="{{ $pn->link_jurnal }}" target="_blank" class="btn-journal-link">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Baca Full PDF
                    </a>
                @endif
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--gray);">
                <i class="fa-solid fa-book-open-reader" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px;"></i>
                <p>Belum ada data publikasi artikel ilmiah berkala yang dimasukkan ke dalam arsip admin.</p>
            </div>
            @endforelse
        </div>
    </section>

    <div class="modal-overlay" id="newsModal">
        <div class="modal-window">
            <span class="close-btn" onclick="closeNews()">×</span>
            <h3 id="mTitle" style="margin-bottom: 20px; color: var(--primary); font-size: 1.4rem; font-weight: 800; line-height: 1.35;"></h3>
            <p id="mBody" style="line-height: 1.7; color: var(--gray); font-size: 0.95rem; text-align: justify;"></p>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Live Search Engine Modul
    const liveSearch = document.getElementById('liveSearch');
    liveSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.prodi-card');
        cards.forEach(card => {
            const targetText = card.getAttribute('data-search').toLowerCase();
            card.style.display = targetText.includes(query) ? 'block' : 'none';
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
    const newsCards = document.querySelectorAll('.news-card');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const targetTab = btn.getAttribute('data-tab');
            newsCards.forEach(card => {
                const type = card.getAttribute('data-type');
                card.style.display = (targetTab === 'all' || type === targetTab) ? 'block' : 'none';
            });
        });
    });

    // Stats Counter Engine
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