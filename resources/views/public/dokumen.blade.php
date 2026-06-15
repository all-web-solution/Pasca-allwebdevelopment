@extends('layouts.public')

@section('title', 'Dokumen Resmi - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Variabel Warna Modern Konsisten */
    :root {
        --yellow-accent: #F59E0B;
        --yellow-light: rgba(245, 158, 11, 0.1);
        --primary-light: rgba(10, 77, 46, 0.08);
        --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.05);
        --card-shadow-hover: 0 25px 50px -12px rgba(10, 77, 46, 0.15);
        --radius-lg: 24px;
        --smooth-transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    section { padding: 80px 8% 100px; position: relative; }

    /* ================================================================= */
    /* UI MODERN: HEADER SEKSI GLOBAL */
    /* ================================================================= */
    .section-header-modern {
        text-align: center; max-width: 700px; margin: 0 auto 50px;
    }
    .section-header-modern h2 {
        font-size: 2.8rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 15px;
    }
    .section-header-modern h2 span { color: var(--yellow-accent); }
    .section-header-modern p { color: var(--gray); font-size: 1.05rem; font-weight: 500; line-height: 1.6; }

    [data-theme="dark"] .section-header-modern h2 { color: #ffffff; }

    /* ================================================================= */
    /* UI MODERN: ACCORDION CARDS (DOKUMEN & FAQ) */
    /* ================================================================= */
    .accordion-container {
        max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;
    }

    .accordion-item {
        background: #ffffff; border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.03); box-shadow: var(--card-shadow);
        transition: var(--smooth-transition); overflow: hidden;
    }
    [data-theme="dark"] .accordion-item { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.05); }

    .accordion-item:hover { transform: translateY(-3px); border-color: rgba(10, 77, 46, 0.2); }

    .accordion-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 25px 30px; cursor: pointer; user-select: none; transition: var(--smooth-transition);
    }
    
    .accordion-header h3 {
        font-size: 1.2rem; font-weight: 700; color: var(--dark); transition: var(--smooth-transition);
    }
    [data-theme="dark"] .accordion-header h3 { color: #F8FAFC; }

    .icon-wrapper {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; transition: var(--smooth-transition); flex-shrink: 0;
    }

    .accordion-content {
        max-height: 0; overflow: hidden; transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        background: transparent;
    }

    .accordion-content-inner {
        padding: 0 30px 30px 30px; color: var(--gray); font-size: 1rem; line-height: 1.7;
    }

    /* Status Aktif (Terbuka) */
    .accordion-item.active {
        border-color: var(--primary); box-shadow: var(--card-shadow-hover);
    }
    .accordion-item.active .accordion-header h3 { color: var(--primary); }
    .accordion-item.active .icon-wrapper {
        background: var(--yellow-accent); color: white; transform: rotate(180deg);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }
    [data-theme="dark"] .accordion-item.active .accordion-header h3 { color: var(--yellow-accent); }

    /* ================================================================= */
    /* UI MODERN: TOMBOL DOWNLOAD PILL STYLE */
    /* ================================================================= */
    .download-btn-group { display: flex; gap: 15px; margin-top: 20px; flex-wrap: wrap; }

    .btn-download {
        display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px;
        background: #ffffff; color: var(--primary); text-decoration: none;
        border-radius: 50px; font-size: 0.9rem; font-weight: 700;
        transition: var(--smooth-transition); border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    [data-theme="dark"] .btn-download { background: rgba(255,255,255,0.05); color: #F8FAFC; border: 1px solid rgba(255,255,255,0.1); }
    
    .btn-download i { color: var(--yellow-accent); font-size: 1.1rem; transition: transform 0.3s ease; }
    
    .btn-download:hover { 
        background: var(--primary); color: white; transform: translateY(-3px); 
        box-shadow: 0 10px 20px rgba(10, 77, 46, 0.2); border-color: var(--primary);
    }
    .btn-download:hover i { transform: translateY(3px); color: white; }
    
    .btn-download span { font-size: 0.75rem; opacity: 0.7; font-weight: 500; background: rgba(0,0,0,0.05); padding: 2px 8px; border-radius: 12px; margin-left: 4px; }
    .btn-download:hover span { background: rgba(255,255,255,0.2); }

    @media (max-width: 768px) {
        .section-header-modern h2 { font-size: 2.2rem; }
        .accordion-header { padding: 20px; }
        .accordion-header h3 { font-size: 1.05rem; }
        .accordion-content-inner { padding: 0 20px 25px 20px; }
        section { padding: 60px 5% 80px; }
    }
</style>
@endsection

@section('content')
    <main class="hero" id="home">
        <div class="slide active" style="background: url('{{ asset('uploads/slider/' . ($sliders->first()->image ?? 'bg-iain.jpeg')) }}') center/cover no-repeat; background-color: var(--primary);">
            <div class="slide-content">
                <div class="badge-hero"><i class="fa-solid fa-folder-open"></i> Pusat Berkas & Legalitas Formal</div>
                <h2>Unduh Dokumen Resmi</h2>
                <p style="margin-bottom: 35px; opacity: 0.9; line-height: 1.6;">Pusat berkas legalitas, panduan akademik, buku saku kurikulum, dan blanko administrasi pendaftaran Pascasarjana IAIN Curup.</p>
                <a href="#dokumen" class="btn-modern">Lihat Berkas <i class="fa-solid fa-arrow-down"></i></a>
            </div>
        </div>
    </main>

    <!-- ================================================================= -->
    <!-- SEKSI 1: UNDUHAN DOKUMEN RESMI -->
    <!-- ================================================================= -->
    <section id="dokumen">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-download" style="margin-right: 4px;"></i> PUSAT UNDUHAN
            </div>
            <h2>Dokumen <span>Resmi</span></h2>
            <p>Silakan perluas tab kartu di bawah untuk mengunduh dokumen sesuai dengan klasifikasi kebutuhan administrasi Anda.</p>
        </div>
        
        <div class="accordion-container">
            <!-- Item 1: Formulir -->
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Formulir Pendaftaran & Persuratan</h3>
                    <div class="icon-wrapper"><i class="fa-solid fa-chevron-down"></i></div>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p>Unduh template blanko persuratan resmi, surat izin riset penelitian, berkas pendaftaran mahasiswa baru, dan administrasi magister.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Formulir') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-file-contract"></i> {{ $doc->nama_dokumen }} <span>{{ $doc->download_count }}x diunduh</span>
                                </a>
                            @empty
                                <span style="font-size: 0.9rem; font-style: italic; color: var(--gray); background: var(--light); padding: 10px 20px; border-radius: 12px;">Belum ada berkas formulir yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2: SOP -->
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Standar Operasional Prosedur (SOP) & Buku Panduan</h3>
                    <div class="icon-wrapper"><i class="fa-solid fa-chevron-down"></i></div>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p>Panduan alur birokrasi pelayanan pascasarjana, mekanisme pengajuan draf tesis, kolokium, layanan perpustakaan, serta integrasi keilmuan Islam.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Panduan') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-book"></i> {{ $doc->nama_dokumen }} <span>{{ $doc->download_count }}x diunduh</span>
                                </a>
                            @empty
                                <span style="font-size: 0.9rem; font-style: italic; color: var(--gray); background: var(--light); padding: 10px 20px; border-radius: 12px;">Belum ada berkas buku panduan/SOP yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 3: Kurikulum & Akreditasi -->
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Kurikulum, SK Legalitas, & Akreditasi</h3>
                    <div class="icon-wrapper"><i class="fa-solid fa-chevron-down"></i></div>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p>Berkas legalitas formal institusional, sertifikat SK Akreditasi BAN-PT tiap Program Studi, Peraturan Menteri Agama (PMA), dan draf jalinan kerja sama domestik.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Kurikulum') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-certificate"></i> {{ $doc->nama_dokumen }} <span>{{ $doc->download_count }}x diunduh</span>
                                </a>
                            @empty
                                <span style="font-size: 0.9rem; font-style: italic; color: var(--gray); background: var(--light); padding: 10px 20px; border-radius: 12px;">Belum ada berkas kurikulum atau sertifikat akreditasi yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- SEKSI 2: PERTANYAAN UMUM (FAQ) YANG DIINPUT DARI ADMIN -->
    <!-- ================================================================= -->
    <section id="faq" style="background: rgba(241, 245, 249, 0.6);">
        <div class="section-header-modern">
            <div style="display: inline-block; padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: var(--primary); font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;">
                <i class="fa-solid fa-circle-question" style="margin-right: 4px;"></i> PUSAT BANTUAN
            </div>
            <h2>Pertanyaan <span>Umum (FAQ)</span></h2>
            <p>Temukan jawaban cepat terkait prosedur pendaftaran, jadwal akademik, dan layanan kemahasiswaan di bawah ini.</p>
        </div>
        
        <div class="accordion-container">
            @forelse($faqs ?? [] as $faq)
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>{{ $faq->pertanyaan }}</h3>
                    <div class="icon-wrapper"><i class="fa-solid fa-chevron-down"></i></div>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p style="white-space: pre-line; color: var(--text-main);">{{ $faq->jawaban }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; color: var(--gray); padding: 40px; background: white; border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
                <i class="fa-solid fa-comments" style="font-size: 2.5rem; margin-bottom: 15px; color: var(--yellow-accent); opacity: 0.8;"></i>
                <p>Belum ada daftar pertanyaan yang dirilis oleh admin.</p>
            </div>
            @endforelse
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Engine Accordion Modern (Bisa untuk Dokumen & FAQ sekaligus)
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const content = header.nextElementSibling;
            
            // Jika yang diklik sudah aktif, maka tutup
            if (item.classList.contains('active')) {
                item.classList.remove('active');
                content.style.maxHeight = null;
            } else {
                // Tutup semua accordion yang ada di dalam container yang sama
                const parentContainer = item.closest('.accordion-container');
                parentContainer.querySelectorAll('.accordion-item').forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.accordion-content').style.maxHeight = null;
                });
                
                // Buka accordion yang diklik
                item.classList.add('active');
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
</script>
@endsection