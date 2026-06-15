@extends('layouts.public')

@section('title', 'Pendidikan & Akademik - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Perbaikan Khusus Grid Layout Halaman Pendidikan */
    .prodi-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
        gap: 30px; 
    }
    .prodi-card {
        background: var(--card-bg); 
        border: 1px solid var(--card-border); 
        padding: 35px;
        border-radius: var(--radius); 
        transition: var(--transition); 
        position: relative; 
        overflow: hidden;
    }
    .prodi-card::before {
        content: ''; 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 5px; 
        height: 100%; 
        background: var(--primary);
    }
    .prodi-card:hover { 
        transform: translateY(-8px); 
        border-color: var(--accent); 
        box-shadow: 0 20px 40px rgba(10, 77, 46, 0.1); 
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
        font-size: 1.3rem; 
    }
    [data-theme="dark"] .prodi-icon { 
        background: rgba(16, 185, 129, 0.2); 
        color: var(--accent); 
    }

    /* Style Komponen Profil Singkat */
    .profile-container {
        display: grid; 
        grid-template-columns: 1.1fr 0.9fr; 
        gap: 50px; 
        align-items: center;
        background: var(--card-bg); 
        border: 1px solid var(--card-border);
        padding: 50px; 
        border-radius: var(--radius); 
        box-shadow: 0 10px 30px rgba(0,0,0,0.01);
        backdrop-filter: blur(10px);
    }
    .profile-text h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; color: var(--primary); }
    [data-theme="dark"] .profile-text h3 { color: var(--accent); }
    .profile-text p { color: var(--gray); line-height: 1.75; margin-bottom: 16px; text-align: justify; font-size: 0.95rem; }
    
    .profile-visual {
        position: relative; 
        height: 380px;
        border-radius: var(--radius); 
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(10, 77, 46, 0.15);
        background-size: cover;
        background-position: center;
    }
    .profile-overlay {
        position: absolute; 
        inset: 0;
        background: linear-gradient(to top, rgba(10, 77, 46, 0.85), transparent);
        display: flex; 
        align-items: flex-end; 
        padding: 30px; 
        color: white;
    }

    /* Style Komponen Guru Besar */
    .professor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    .prof-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        padding: 30px 20px;
        border-radius: var(--radius);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        text-align: center;
        transition: var(--transition);
    }
    .prof-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .prof-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 15px;
        background-size: cover;
        background-position: center;
        border: 3px solid var(--primary);
    }

    /* Layout Komunikasi */
    .contact-layout { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; }
    .contact-box { background: var(--card-bg); border: 1px solid var(--card-border); padding: 40px; border-radius: var(--radius); box-shadow: 0 10px 30px rgba(0,0,0,0.01); }
    .form-group { margin-bottom: 20px; }
    .form-group input, .form-group textarea {
        width: 100%; padding: 15px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--light); color: var(--dark); outline: none; font-size: 0.95rem; transition: var(--transition);
    }
    .form-group input:focus, .form-group textarea:focus { border-color: var(--primary); background: var(--secondary); }
    
    .btn-send {
        width: 100%; padding: 15px; background: var(--primary); color: white; border: none; border-radius: 30px; font-weight: 700; cursor: pointer; transition: var(--transition); box-shadow: 0 8px 20px rgba(10, 77, 46, 0.15);
    }
    .btn-send:hover { background: var(--accent); transform: translateY(-2px); box-shadow: 0 12px 24px rgba(16, 185, 129, 0.2); }

    .info-box { display: flex; flex-direction: column; gap: 24px; }
    .info-card { background: var(--card-bg); border: 1px solid var(--card-border); padding: 30px; border-radius: var(--radius); }
    .info-item { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
    .info-item:last-child { margin-bottom: 0; }
    .info-icon { width: 45px; height: 45px; background: rgba(16, 185, 129, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.1rem; }
    .info-text h4 { font-size: 0.85rem; color: var(--gray); font-weight: 500; margin-bottom: 2px; }
    .info-text p { font-size: 0.95rem; font-weight: 700; }

    .social-container { display: flex; gap: 12px; margin-top: 15px; }
    .social-circle { width: 45px; height: 45px; background: var(--light); border: 1px solid var(--card-border); color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: var(--transition); font-size: 1.1rem; }
    .social-circle:hover { background: var(--primary); color: white; transform: translateY(-3px); }

    .map-wrapper {
        background: var(--card-bg); border: 1px solid var(--card-border); padding: 12px; border-radius: var(--radius); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.01); height: 450px;
    }
    .map-wrapper iframe { width: 100%; height: 100%; border: none; border-radius: 10px; }

    @media (max-width: 992px) {
        .profile-container, .contact-layout { grid-template-columns: 1fr; gap: 30px; }
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
   
    <section id="profile">
        <div class="section-header">
            <h2>Profil & Latar Belakang</h2>
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
                        <h4 style="font-weight: 800; font-size: 1.3rem;">Gedung Sentral Pascasarjana</h4>
                        <p style="font-size: 0.85rem; opacity: 0.9;">Inkubator riset ilmiah & transformasi kurikulum digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="prodi" style="background: rgba(241, 245, 249, 0.4);">
        <div class="section-header">
            <h2>Program Studi Magister</h2>
            <p>Rumpun program studi unggulan pilihan yang adaptif terhadap akselerasi dunia kerja profesional</p>
        </div>

        <div class="search-wrapper" style="max-width: 600px; margin: 0 auto 40px;">
            <input type="text" id="liveSearch" placeholder="Cari nama program studi... (Contoh: PAI, MPI, Hukum)" style="width: 100%; padding: 16px 24px; border-radius: 30px; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--dark); outline: none;">
        </div>

        <div class="prodi-grid" id="prodiContainer">
            @foreach ($prodi as $p)
            <div class="prodi-card" data-search="{{ $p->search_tags }}">
                <div class="prodi-icon"><i class="fa-solid {{ $p->icon }}"></i></div>
                <h3>{{ $p->nama }}</h3>
                <p style="color: var(--gray); font-size: 0.9rem; margin-top: 12px; line-height: 1.5;">{{ $p->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section id="gurubesar">
        <div class="section-header">
            <h2>Dewan Guru Besar & Promotor</h2>
            <p>Jajaran ilmuwan senior, pakar, dan promotor utama akselerasi karya ilmiah pascasarjana</p>
        </div>
        
        <div class="professor-grid" style="margin-top: 50px;">
            @foreach($gurubesar as $gb)
            <div class="prof-card">
                <div class="prof-avatar" style="background-image: url('{{ asset('img/prof/' . $gb->foto) }}');"></div>
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 5px;">
                    {{ $gb->gelar_depan ? $gb->gelar_depan . ' ' : '' }}{{ $gb->nama }}{{ $gb->gelar_belakang ? ', ' . $gb->gelar_belakang : '' }}
                </h3>
                <p style="color: var(--primary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">{{ $gb->bidang_keahlian }}</p>
                <p style="color: var(--gray); font-size: 0.85rem; line-height: 1.4;">{{ $gb->biografi_singkat }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section id="contact" style="background: rgba(241, 245, 249, 0.4);">
        <div class="section-header">
            <h2>Kanal Interaksi & Informasi</h2>
            <p>Ajukan pertanyaan konsultasi akademik secara langsung atau ikuti jaringan media komunikasi kami</p>
        </div>
        <div class="contact-layout">
            <div class="contact-box">
                <form id="contactForm">
                    <div class="form-group"><input type="text" id="name" placeholder="Nama Lengkap Anda" required></div>
                    <div class="form-group"><input type="email" id="email" placeholder="Alamat Email Aktif" required></div>
                    <div class="form-group"><textarea id="message" rows="5" placeholder="Tulis rincian pertanyaan konsultasi prodi atau pendaftaran akademik..." required></textarea></div>
                    <button type="submit" class="btn-send">Kirim Enkripsi Pesan</button>
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
                    <h4 style="margin-bottom: 12px; font-weight: 700; font-size: 1rem;">Kanal Media Sosial Resmi</h4>
                    <p style="color: var(--gray); font-size: 0.85rem; margin-bottom: 15px;">Ikuti publikasi dokumentasi kegiatan, info seminar, dan pengumuman berbasis komunitas digital kami:</p>
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

    <section id="lokasi">
        <div class="section-header">
            <h2>Peta Geografis Kampus</h2>
            <p>Alamat: Jl. Dr. AK Gani No. 01, Curup Tengah, Kabupaten Rejang Lebong, Bengkulu</p>
        </div>
        <div class="map-wrapper">
            <iframe src="https://maps.google.com/maps?q=IAIN%20Curup&t=&z=15&ie=UTF-8&iwloc=&output=embed" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div style="text-align: center; margin-top: 25px;">
            <a href="https://maps.app.goo.gl/i1mUwtj5sfUB22oBA" target="_blank" class="btn-modern" style="display: inline-flex; align-items: center; gap: 10px; width: auto; padding: 12px 30px; text-decoration: none; color: white; background: var(--primary);">
                <i class="fa-solid fa-map-location-dot"></i> Buka Direktori Google Maps
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Live Search Prodi Matrix
    const liveSearch = document.getElementById('liveSearch');
    liveSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.prodi-card');
        cards.forEach(card => {
            const targetText = card.getAttribute('data-search').toLowerCase();
            card.style.display = targetText.includes(query) ? 'block' : 'none';
        });
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