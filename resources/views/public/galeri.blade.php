@extends('layouts.public')

@section('title', 'Galeri Dokumentasi - Pascasarjana IAIN Curup')

@section('styles')
<style>
    :root {
        --yellow-accent: #F59E0B;
        --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.05);
        --radius-lg: 24px;
        --smooth-transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    section { padding: 80px 8% 100px; position: relative; }

    .section-header-modern { text-align: center; max-width: 700px; margin: 0 auto 50px; }
    .section-header-modern h2 { font-size: 2.8rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 15px; }
    .section-header-modern h2 span { color: var(--yellow-accent); }
    .section-header-modern p { color: var(--gray); font-size: 1.05rem; font-weight: 500; line-height: 1.6; }
    [data-theme="dark"] .section-header-modern h2 { color: #ffffff; }

    /* MODERN GALLERY MASONRY/GRID */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .gallery-card {
        position: relative; border-radius: var(--radius-lg); overflow: hidden;
        aspect-ratio: 4 / 3; cursor: pointer; box-shadow: var(--card-shadow);
        background: var(--card-border);
    }

    .gallery-img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .gallery-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.2) 60%, transparent 100%);
        display: flex; flex-direction: column; justify-content: flex-end;
        padding: 30px; opacity: 0; transition: var(--smooth-transition);
        transform: translateY(20px);
    }

    .gallery-card:hover .gallery-img { transform: scale(1.1); }
    .gallery-card:hover .gallery-overlay { opacity: 1; transform: translateY(0); }

    /* Badge Tanggal di Kartu Hover */
    .gallery-date { 
        color: var(--yellow-accent); font-size: 0.8rem; font-weight: 700; 
        margin-bottom: 8px; display: inline-flex; align-items: center; gap: 6px; 
        text-transform: uppercase; letter-spacing: 0.5px; 
    }

    .gallery-overlay h3 { color: #ffffff; font-size: 1.4rem; font-weight: 800; margin-bottom: 8px; line-height: 1.3; }
    .gallery-overlay p { color: #CBD5E1; font-size: 0.95rem; line-height: 1.5; }
    .gallery-overlay .icon-zoom { 
        position: absolute; top: 25px; right: 25px; width: 45px; height: 45px;
        background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; transform: scale(0); transition: var(--smooth-transition) 0.1s;
    }
    .gallery-card:hover .icon-zoom { transform: scale(1); }

    /* LIGHTBOX MODAL FULLSCREEN */
    .lightbox-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(2, 6, 23, 0.95); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
        z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: var(--smooth-transition);
    }
    .lightbox-overlay.active { opacity: 1; pointer-events: auto; }
    
    .lightbox-close {
        position: absolute; top: 30px; right: 40px; color: white; font-size: 2.5rem;
        cursor: pointer; transition: transform 0.3s ease; width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center; border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }
    .lightbox-close:hover { transform: rotate(90deg); background: #EF4444; }

    .lightbox-content {
        max-width: 90%; max-height: 70vh;
        border-radius: 16px; box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        object-fit: contain; transform: scale(0.95); transition: var(--smooth-transition);
    }
    .lightbox-overlay.active .lightbox-content { transform: scale(1); }

    .lightbox-text {
        text-align: center; color: white; margin-top: 25px; max-width: 800px;
        transform: translateY(20px); opacity: 0; transition: all 0.5s ease 0.2s;
    }
    .lightbox-overlay.active .lightbox-text { transform: translateY(0); opacity: 1; }
    
    /* Badge Tanggal di Modal Bawah */
    .lightbox-date { 
        display: inline-block; padding: 6px 16px; background: rgba(245, 158, 11, 0.15); 
        color: var(--yellow-accent); font-size: 0.8rem; font-weight: 800; 
        border-radius: 30px; margin-bottom: 12px; letter-spacing: 1px; 
    }
    
    .lightbox-text h3 { font-size: 1.8rem; font-weight: 800; margin-bottom: 10px; color: #ffffff; }
    .lightbox-text p { font-size: 1rem; color: #CBD5E1; line-height: 1.6; }

    @media (max-width: 768px) {
        .section-header-modern h2 { font-size: 2.2rem; }
        .gallery-grid { grid-template-columns: 1fr; }
        .gallery-overlay { opacity: 1; transform: translateY(0); background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, transparent 100%); }
        .icon-zoom { display: none; }
        .lightbox-close { top: 15px; right: 20px; font-size: 2rem; width: 40px; height: 40px; }
        .lightbox-text h3 { font-size: 1.4rem; }
    }
</style>
@endsection

@section('content')
    <main class="hero" id="home">
        <div class="slide active" style="background: url('{{ asset('uploads/slider/' . ($sliders->first()->image ?? 'bg-iain2.jpeg')) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-camera-retro"></i> Momen & Dokumentasi</div>
                <h2>Galeri Pascasarjana</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Rekam jejak visual kegiatan akademik, sidang, seminar, hingga fasilitas kampus Pascasarjana IAIN Curup.</p>
                <a href="#galeri" class="btn-modern">Eksplorasi Galeri <i class="fa-solid fa-arrow-down"></i></a>
            </div>
        </div>
    </main>

    <section id="galeri">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-images" style="margin-right: 4px;"></i> ALBUM DIGITAL
            </div>
            <h2>Dokumentasi <span>Kampus</span></h2>
            <p>Jelajahi momen inspiratif dan kilas balik aktivitas civitas akademika di lingkungan Pascasarjana.</p>
        </div>

        <div class="gallery-grid">
            @forelse($galeris as $g)
            <div class="gallery-card" onclick="openLightbox('{{ asset('uploads/galeri/' . $g->gambar) }}', '{{ addslashes($g->judul) }}', '{{ addslashes($g->deskripsi) }}', '{{ \Carbon\Carbon::parse($g->created_at)->translatedFormat('d F Y') }}')">
                <img src="{{ asset('uploads/galeri/' . $g->gambar) }}" alt="{{ $g->judul }}" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                    <div class="icon-zoom"><i class="fa-solid fa-expand"></i></div>
                    <span class="gallery-date"><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($g->created_at)->translatedFormat('d F Y') }}</span>
                    <h3>{{ $g->judul }}</h3>
                    <p>{{ Str::limit($g->deskripsi, 60) }}</p>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; color: var(--gray); padding: 60px; background: rgba(241, 245, 249, 0.4); border-radius: var(--radius-lg); border: 1px dashed rgba(0,0,0,0.05);">
                <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--yellow-accent); margin-bottom: 20px; opacity: 0.7;"></i>
                <p style="font-size: 1.1rem;">Belum ada album dokumentasi yang diunggah.</p>
            </div>
            @endforelse
        </div>
    </section>

    <div class="lightbox-overlay" id="lightbox">
        <div class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></div>
        <img src="" class="lightbox-content" id="lightboxImg">
        <div class="lightbox-text">
            <div id="lightboxDate" class="lightbox-date"></div>
            <h3 id="lightboxTitle"></h3>
            <p id="lightboxDesc"></p>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Fitur Lightbox Pintar (Menerima Tanggal)
    function openLightbox(imgSrc, title, desc, date) {
        document.getElementById('lightboxImg').src = imgSrc;
        document.getElementById('lightboxTitle').innerText = title;
        document.getElementById('lightboxDesc').innerText = desc || '';
        
        // Memasukkan format teks tanggal ke dalam modal
        document.getElementById('lightboxDate').innerHTML = `<i class="fa-regular fa-calendar" style="margin-right: 6px;"></i> ${date}`;
        
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden'; // Kunci scroll background
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = 'auto'; // Buka scroll background
        setTimeout(() => {
            document.getElementById('lightboxImg').src = ''; // Clear image setelah animasi nutup
        }, 400);
    }

    // Tutup lightbox kalau klik di area hitam/luar gambar
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if(e.target === this) {
            closeLightbox();
        }
    });

    // Keyboard ESC untuk tutup lightbox
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape" && document.getElementById('lightbox').classList.contains('active')) {
            closeLightbox();
        }
    });
</script>
@endsection