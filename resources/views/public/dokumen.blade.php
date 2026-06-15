@extends('layouts.public')

@section('title', 'Dokumen Resmi - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Interaktif Accordion Document Section */
    section { padding: 60px 12% 80px; position: relative; }
    .document-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -1px;
        color: #1E293B;
        margin-bottom: 12px;
    }
    [data-theme="dark"] .document-title { color: #ffffff; }
    
    .document-subtitle {
        text-align: center;
        color: var(--gray);
        margin-bottom: 60px;
        font-size: 1rem;
    }

    .accordion-container {
        max-width: 1000px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }

    .accordion-item {
        border-bottom: 1px solid #E2E8F0;
        background: transparent;
        transition: var(--transition);
    }
    [data-theme="dark"] .accordion-item { border-bottom: 1px solid #334155; }

    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 10px;
        cursor: pointer;
        user-select: none;
        transition: var(--transition);
    }
    
    .accordion-header h3 {
        font-size: 1.15rem;
        font-weight: 600;
        color: #334155;
        transition: var(--transition);
    }
    [data-theme="dark"] .accordion-header h3 { color: #CBD5E1; }

    .accordion-icon {
        font-size: 1.1rem;
        color: #64748B;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        background: transparent;
    }

    .accordion-content-inner {
        padding: 0 10px 30px 10px;
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .accordion-item.active .accordion-header h3 {
        color: var(--primary);
        font-weight: 700;
    }
    [data-theme="dark"] .accordion-item.active .accordion-header h3 { color: var(--accent); }

    .accordion-item.active .accordion-icon {
        transform: rotate(180deg);
        color: var(--primary);
    }
    [data-theme="dark"] .accordion-item.active .accordion-icon { color: var(--accent); }

    .download-btn-group {
        display: flex;
        gap: 12px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(10, 77, 46, 0.05);
        color: var(--primary);
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        transition: var(--transition);
        border: 1px solid rgba(10, 77, 46, 0.1);
    }
    [data-theme="dark"] .btn-download { background: rgba(16, 185, 129, 0.1); color: var(--accent); border: 1px solid rgba(16, 185, 129, 0.15); }
    .btn-download:hover { background: var(--primary); color: white; transform: translateY(-2px); }
    [data-theme="dark"] .btn-download:hover { background: var(--accent); color: var(--dark); }

    .btn-download span { font-size: 0.75rem; opacity: 0.7; font-weight: 400; }

    @media (max-width: 768px) {
        .accordion-header h3 { font-size: 1rem; }
        section { padding: 60px 6% 60px; }
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

    <section id="dokumen">
        <h2 class="document-title">Dokumen Resmi</h2>
        <p class="document-subtitle">Silakan perluas tab di bawah untuk mengunduh dokumen sesuai klasifikasi kebutuhan</p>
        
        <div class="accordion-container">
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Formulir Pendaftaran & Persuratan</h3>
                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p style="margin-bottom: 15px;">Unduh template blanko persuratan resmi, surat izin riset penelitian, berkas pendaftaran mahasiswa baru, dan administrasi magister.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Formulir') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-file-contract"></i> {{ $doc->nama_dokumen }} <span>({{ $doc->download_count }}x diunduh)</span>
                                </a>
                            @empty
                                <span style="font-size: 0.85rem; font-style: italic; color: var(--gray);">Belum ada berkas formulir yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Standar Operasional Prosedur (SOP) & Buku Panduan</h3>
                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p style="margin-bottom: 15px;">Panduan alur birokrasi pelayanan pascasarjana, mekanisme pengajuan draf tesis, kolokium, layanan perpustakaan, serta integrasi keilmuan Islam.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Panduan') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-book"></i> {{ $doc->nama_dokumen }} <span>({{ $doc->download_count }}x diunduh)</span>
                                </a>
                            @empty
                                <span style="font-size: 0.85rem; font-style: italic; color: var(--gray);">Belum ada berkas buku panduan/SOP yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>Kurikulum, SK Legalitas, & Akreditasi</h3>
                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content">
                    <div class="accordion-content-inner">
                        <p style="margin-bottom: 15px;">Berkas legalitas formal institusional, sertifikat SK Akreditasi BAN-PT tiap Program Studi, Peraturan Menteri Agama (PMA), dan draf jalinan kerja sama domestik.</p>
                        <div class="download-btn-group">
                            @forelse($dokumen->where('kategori', 'Kurikulum') as $doc)
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" class="btn-download">
                                    <i class="fa-solid fa-certificate"></i> {{ $doc->nama_dokumen }} <span>({{ $doc->download_count }}x diunduh)</span>
                                </a>
                            @empty
                                <span style="font-size: 0.85rem; font-style: italic; color: var(--gray);">Belum ada berkas kurikulum atau sertifikat akreditasi yang diunggah oleh admin.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const content = header.nextElementSibling;
            
            if (item.classList.contains('active')) {
                item.classList.remove('active');
                content.style.maxHeight = null;
            } else {
                document.querySelectorAll('.accordion-item').forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.accordion-content').style.maxHeight = null;
                });
                
                item.classList.add('active');
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
</script>
@endsection