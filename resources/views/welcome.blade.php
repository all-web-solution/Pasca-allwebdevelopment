@extends('layouts.public')

@section('title', 'Beranda - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Grid Layout Khusus Halaman Konten Beranda */
    .prodi-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
        gap: 30px; 
    }
    .prodi-card {
        background: var(--card-bg); 
        border: 1px solid var(--card-border); 
        padding: 32px;
        border-radius: var(--radius); 
        transition: var(--transition); 
        cursor: pointer;
    }
    .prodi-card:hover { 
        transform: translateY(-8px); 
        border-color: var(--accent); 
        box-shadow: 0 20px 30px rgba(0,0,0,0.04); 
    }
    .prodi-icon { 
        width: 50px; 
        height: 50px; 
        background: rgba(10, 77, 46, 0.1); 
        color: var(--primary); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 12px; 
        margin-bottom: 20px; 
        font-size: 1.25rem; 
    }
    [data-theme="dark"] .prodi-icon { 
        background: rgba(16, 185, 129, 0.2); 
        color: var(--accent); 
    }

    /* PREMIUM HORIZONTAL SCROLL NEWS HUB (1 BARIS KE SAMPING) */
    .news-tabs { display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; }
    .tab-btn { padding: 10px 24px; border-radius: 30px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark); font-weight: 600; cursor: pointer; transition: var(--transition); }
    .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    
    .news-grid { 
        display: flex; 
        gap: 30px; 
        overflow-x: auto; 
        padding: 10px 4px 30px 4px;
        scroll-behavior: smooth;
        snap-type: x mandatory;
        transition: opacity 0.3s ease; 
    }
    .news-grid::-webkit-scrollbar { height: 8px; }
    .news-grid::-webkit-scrollbar-track { background: transparent; }
    .news-grid::-webkit-scrollbar-thumb { background: var(--card-border); border-radius: 20px; }
    .news-grid:hover::-webkit-scrollbar-thumb { background: var(--gray); }

    .news-card { 
        flex: 0 0 360px; 
        snap-align: start;
        background: var(--card-bg); 
        border-radius: var(--radius); 
        border: 1px solid var(--card-border); 
        overflow: hidden; 
        transition: var(--transition); 
        display: flex;
        flex-direction: column;
    }
    .news-card:hover { transform: translateY(-6px); border-color: var(--accent); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
    .news-cover { width: 100%; height: 200px; background-size: cover; background-position: center; }
    .news-content { padding: 24px; display: flex; flex-direction: column; flex: 1; }
    .news-meta { display: flex; gap: 12px; font-size: 0.8rem; color: var(--gray); margin-bottom: 12px; }
    
    .news-action-wrapper { margin-top: auto; padding-top: 20px; }
    .btn-read-news {
        display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem;
        font-weight: 700; color: var(--primary); background: transparent; border: none;
        cursor: pointer; transition: var(--transition); padding: 0;
    }
    [data-theme="dark"] .btn-read-news { color: var(--accent); }
    .btn-read-news:hover { gap: 12px; opacity: 0.8; }

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

    <div class="stats-container">
        <div class="stats-grid" id="statsGrid">
            <div class="stat-item"><h3 class="counter" data-target="8">0</h3><p>Klaster Komparatif S2</p></div>
            <div class="stat-item"><h3 class="counter" data-target="450">0</h3><p>Riset Mahasiswa Aktif</p></div>
            <div class="stat-item"><h3 class="counter" data-target="35">0</h3><p>Dewan Profesor & Doktor</p></div>
        </div>
    </div>

    <section id="prodi">
        <div class="section-header">
            <h2>Program Studi Magister</h2>
            <p>Sistem navigasi instan pemetaan konsentrasi akademik pascasarjana</p>
        </div>
        <div class="search-wrapper" style="max-width: 600px; margin: 0 auto 40px;">
            <input type="text" id="liveSearch" placeholder="Ketik kata kunci prodi (misal: PAI, HKI, Manajemen)..." style="width: 100%; padding: 16px 24px; border-radius: 30px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark); outline: none;">
        </div>
        <div class="prodi-grid" id="prodiContainer">
            @foreach ($prodi as $p)
            <div class="prodi-card" data-search="{{ $p->search_tags }}">
                <div class="prodi-icon"><i class="fa-solid {{ $p->icon }}"></i></div>
                <h3>{{ $p->nama }}</h3>
                <p style="color: var(--gray); font-size: 0.9rem; margin-top: 12px; line-height: 1.5;">{{ $p->deskripsi }}</p>
            </div>
            @endforeach
            
            <div id="noProdiAlert" style="display: none; grid-column: 1/-1; text-align: center; padding: 40px; color: var(--gray);">
                <i class="fa-solid fa-magnifying-glass-blur" style="font-size: 2rem; margin-bottom: 15px; color: var(--primary);"></i>
                <p>Program Studi tidak ditemukan. Coba kata kunci lain (PAI, HKI, MPI).</p>
            </div>
        </div>
    </section>

    <section id="news" style="background: rgba(241, 245, 249, 0.4);">
        <div class="section-header">
            <h2>Pusat Informasi & Pemberitaan</h2>
            <p>Arsip digital aktivitas riset, agenda kerja, dan pembaruan berkala (Geser ke samping)</p>
        </div>

        <div class="news-tabs">
            <button class="tab-btn active" data-tab="all">Semua</button>
            <button class="tab-btn" data-tab="akademik">Akademik</button>
            <button class="tab-btn" data-tab="pengumuman">Pengumuman</button>
        </div>

        <div class="news-grid" id="newsContainer">
            @foreach ($berita as $b)
            <div class="news-card" data-type="{{ $b->kategori }}">
                <div class="news-cover" style="background-image: url('{{ asset('img/' . $b->cover) }}')"></div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fa-solid fa-calendar"></i> {{ $b->created_at->format('d M Y') }}</span>
                        <span>•</span>
                        <span style="text-transform: capitalize; font-weight: 700;">{{ $b->kategori }}</span>
                    </div>
                    <h4 style="margin-bottom: 10px; font-weight: 700; line-height: 1.4; color: var(--dark);">{{ Str::limit($b->judul, 60) }}</h4>
                    <p style="color: var(--gray); font-size: 0.85rem; line-height: 1.5;">{{ Str::words(strip_tags($b->konten), 12, '...') }}</p>
                    
                    <div class="news-action-wrapper">
                        <button class="btn-read-news" data-judul="{{ $b->judul }}" data-konten="{{ $b->konten }}">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section id="contact">
        <div class="section-header">
            <h2>Kanal Komunikasi Instan</h2>
            <p>Hubungi sekretariat administrasi layanan pascasarjana secara langsung</p>
        </div>
        <div style="max-width: 600px; margin: 0 auto;">
            <form id="interactiveForm" style="display: flex; flex-direction: column; gap: 20px;">
                <input type="text" id="senderName" placeholder="Nama Lengkap Anda" style="padding: 16px; border-radius: 12px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark);" required>
                <textarea id="senderMsg" rows="5" placeholder="Tulis rincian pesan atau pertanyaan konsultasi prodi..." style="padding: 16px; border-radius: 12px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark);" required></textarea>
                <button type="submit" class="btn-modern" style="justify-content: center; color: white; background: var(--primary);">Kirim Enkripsi Pesan</button>
            </form>
        </div>
    </section>

    <div class="modal-overlay" id="newsModal">
        <div class="modal-window">
            <span class="close-btn" onclick="closeNews()">×</span>
            <h3 id="mTitle" style="margin-bottom: 20px; color: var(--primary); font-size: 1.4rem; font-weight: 800; line-height: 1.35;"></h3>
            <div id="mBody" style="line-height: 1.7; color: var(--text-main); font-size: 0.95rem; text-align: justify; max-height: 350px; overflow-y: auto; padding-right: 8px;"></div>
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

    // Live Search Prodi & Empty State Handler
    const liveSearch = document.getElementById('liveSearch');
    const noProdiAlert = document.getElementById('noProdiAlert');
    
    liveSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.prodi-card');
        let foundCounter = 0;

        cards.forEach(card => {
            const targetText = card.getAttribute('data-search').toLowerCase();
            if(targetText.includes(query)) {
                card.style.display = 'block';
                foundCounter++;
            } else {
                card.style.display = 'none';
            }
        });

        noProdiAlert.style.display = foundCounter === 0 ? 'block' : 'none';
    });

    // Dynamic News Tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const newsCards = document.querySelectorAll('.news-card');
    const newsContainer = document.getElementById('newsContainer');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const targetTab = btn.getAttribute('data-tab');

            newsContainer.style.opacity = '0.2';
            setTimeout(() => {
                newsContainer.style.opacity = '1';
                newsCards.forEach(card => {
                    const type = card.getAttribute('data-type');
                    card.style.display = (targetTab === 'all' || type === targetTab) ? 'block' : 'none';
                });
            }, 300);
        });
    });

    // Modal Reader Box Engine (Anti-Crash)
    document.querySelectorAll('.btn-read-news').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('mTitle').innerText = this.getAttribute('data-judul');
            document.getElementById('mBody').innerHTML = this.getAttribute('data-konten').replace(/\n/g, '<br>');
            document.getElementById('newsModal').classList.add('active');
        });
    });

    function closeNews() {
        document.getElementById('newsModal').classList.remove('active');
    }

    // Stats Counter
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

    // Form Submit
    document.getElementById('interactiveForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const name = document.getElementById('senderName').value;
        showToast(`Pesan aman dari ${name} berhasil dikirim ke sekretariat.`);
        document.getElementById('interactiveForm').reset();
    });
</script>
@endsection