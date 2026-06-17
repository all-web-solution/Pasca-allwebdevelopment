@extends('layouts.public')

@section('title', 'Detail Program Studi - Pascasarjana IAIN Curup')

@section('styles')
<style>
    :root {
        --card-shadow: 0 15px 35px -5px rgba(0,0,0,0.05);
        --sidebar-width: 280px;
    }

    /* HERO SECTION */
    .prodi-hero {
        position: relative; height: 50vh; min-height: 400px; width: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, #06311e 100%);
        display: flex; align-items: center; justify-content: center;
        text-align: center; color: white; padding: 0 5%; z-index: 1;
    }
    .prodi-hero::after {
        content: '\f19d'; font-family: 'FontAwesome'; position: absolute;
        font-size: 300px; color: rgba(255,255,255,0.03); right: 10%; bottom: -50px;
        transform: rotate(-15deg); z-index: -1;
    }
    .prodi-hero-content { position: relative; z-index: 2; transform: translateY(-20px); }
    .prodi-hero-badge {
        display: inline-block; padding: 8px 20px; background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px); border-radius: 30px; font-size: 0.85rem;
        font-weight: 700; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.2);
    }
    .prodi-hero h1 { font-size: 3rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 10px; }
    
    @media (max-width: 768px) { .prodi-hero h1 { font-size: 2.2rem; } }

    /* LAYOUT UTAMA */
    .prodi-layout-wrapper {
        max-width: 1200px; margin: -80px auto 100px; padding: 0 20px;
        position: relative; z-index: 10; display: flex; gap: 30px; align-items: flex-start;
    }

    /* SIDEBAR MENU */
    .prodi-sidebar {
        width: var(--sidebar-width); flex-shrink: 0;
        background: #ffffff; border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow); padding: 15px;
        position: sticky; top: 100px; border: 1px solid rgba(0,0,0,0.03);
    }
    [data-theme="dark"] .prodi-sidebar { background: rgba(15, 23, 42, 0.9); border-color: rgba(255,255,255,0.05); }

    .prodi-tab-btn {
        width: 100%; text-align: left; padding: 16px 20px; margin-bottom: 5px;
        background: transparent; border: none; border-radius: 12px;
        font-size: 0.95rem; font-weight: 700; color: var(--gray); cursor: pointer;
        transition: var(--smooth-transition); display: flex; align-items: center; gap: 12px;
    }
    .prodi-tab-btn i { width: 20px; text-align: center; font-size: 1.1rem; opacity: 0.7; }
    .prodi-tab-btn:hover { background: var(--light); color: var(--primary); }
    [data-theme="dark"] .prodi-tab-btn:hover { background: rgba(255,255,255,0.05); }

    .prodi-tab-btn.active { background: var(--primary-light); color: var(--primary); box-shadow: inset 3px 0 0 var(--primary); }
    [data-theme="dark"] .prodi-tab-btn.active { background: rgba(245, 158, 11, 0.1); color: var(--yellow-accent); box-shadow: inset 3px 0 0 var(--yellow-accent); }
    .prodi-tab-btn.active i { opacity: 1; }

    /* KONTEN UTAMA */
    .prodi-main-content {
        flex-grow: 1; background: #ffffff; border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow); padding: 45px; min-height: 500px;
        border: 1px solid rgba(0,0,0,0.03); width: 100%;
    }
    [data-theme="dark"] .prodi-main-content { background: rgba(15, 23, 42, 0.9); border-color: rgba(255,255,255,0.05); }

    .tab-pane { display: none; animation: fadeIn 0.4s ease; }
    .tab-pane.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Text & Typography (Dynamic Render Fix) */
    .tab-pane h2 { font-size: 1.8rem; font-weight: 800; color: var(--dark); margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px dashed rgba(0,0,0,0.1); }
    [data-theme="dark"] .tab-pane h2 { color: #ffffff; border-color: rgba(255,255,255,0.1); }
    
    .html-rendered-content p { font-size: 1rem; line-height: 1.8; color: var(--gray); margin-bottom: 15px; text-align: justify; }
    .html-rendered-content ul { margin-left: 20px; margin-bottom: 20px; color: var(--gray); line-height: 1.8; }
    .html-rendered-content li { margin-bottom: 8px; }
    .html-rendered-content table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
    .html-rendered-content th { background: var(--primary); color: white; padding: 12px 15px; text-align: left; }
    .html-rendered-content td { padding: 12px 15px; border-bottom: 1px solid rgba(0,0,0,0.05); color: var(--gray); }
    
    .empty-state {
        text-align: center; padding: 40px; border-radius: 16px; background: var(--light);
        border: 1px dashed rgba(0,0,0,0.1); color: var(--gray); margin-top: 20px;
    }
    [data-theme="dark"] .empty-state { background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.1); }

    @media (max-width: 992px) {
        .prodi-layout-wrapper { flex-direction: column; margin-top: -40px; }
        .prodi-sidebar { width: 100%; position: static; display: flex; overflow-x: auto; padding: 10px; gap: 10px; scrollbar-width: none; border-radius: 16px; }
        .prodi-sidebar::-webkit-scrollbar { display: none; }
        .prodi-tab-btn { flex: 0 0 auto; width: auto; margin-bottom: 0; white-space: nowrap; padding: 12px 20px; }
        .prodi-tab-btn.active { box-shadow: none; border-bottom: 3px solid var(--primary); border-radius: 12px 12px 0 0; }
        .prodi-main-content { padding: 30px; width: 100%; overflow-x: hidden; }
    }
</style>
@endsection

@section('content')
    <header class="prodi-hero">
        <div class="prodi-hero-content">
            <div class="prodi-hero-badge"><i class="fa-solid {{ $prodi->icon }}"></i> Program Magister (S2)</div>
            
            <!-- Nama Prodi dari Database -->
            <h1>{{ $prodi->nama }}</h1> 
            <p style="font-size: 1.1rem; opacity: 0.9;">Pascasarjana IAIN Curup</p>
        </div>
    </header>

    <div class="prodi-layout-wrapper">
        
        <aside class="prodi-sidebar">
            <button class="prodi-tab-btn active" data-target="profil"><i class="fa-solid fa-building-columns"></i> Profil Prodi</button>
            <button class="prodi-tab-btn" data-target="visi"><i class="fa-solid fa-bullseye"></i> Visi & Misi</button>
            <button class="prodi-tab-btn" data-target="kurikulum"><i class="fa-solid fa-book-open"></i> Kurikulum</button>
            <button class="prodi-tab-btn" data-target="dosen"><i class="fa-solid fa-users"></i> Tenaga Pengajar</button>
            <button class="prodi-tab-btn" data-target="dokumen"><i class="fa-solid fa-file-pdf"></i> Dokumen Unduhan</button>
        </aside>

        <main class="prodi-main-content">
            
            <div id="profil" class="tab-pane active">
                <h2>Profil Program Studi</h2>
                <div class="html-rendered-content">
                    @if($prodi->profil)
                        {!! $prodi->profil !!}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>Data profil program studi belum ditambahkan oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div id="visi" class="tab-pane">
                <h2>Visi & Misi</h2>
                <div class="html-rendered-content">
                    @if($prodi->visi_misi)
                        {!! $prodi->visi_misi !!}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>Data visi & misi program studi belum ditambahkan oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div id="kurikulum" class="tab-pane">
                <h2>Struktur Kurikulum</h2>
                <div class="html-rendered-content">
                    @if($prodi->kurikulum)
                        {!! $prodi->kurikulum !!}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>Data kurikulum program studi belum ditambahkan oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div id="dosen" class="tab-pane">
                <h2>Dewan Tenaga Pengajar</h2>
                <div class="html-rendered-content">
                    @if($prodi->dosen)
                        {!! $prodi->dosen !!}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>Data tenaga pengajar program studi belum ditambahkan oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div id="dokumen" class="tab-pane">
                <h2>Dokumen & Legalitas Prodi</h2>
                <div class="html-rendered-content">
                    @if($prodi->dokumen)
                        {!! $prodi->dokumen !!}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                            <p>Data dokumen program studi belum ditambahkan oleh administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

        </main>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabBtns = document.querySelectorAll('.prodi-tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                btn.classList.add('active');

                const targetId = btn.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
                
                if(window.innerWidth <= 992) {
                    const contentTop = document.querySelector('.prodi-main-content').offsetTop - 120;
                    window.scrollTo({ top: contentTop, behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endsection