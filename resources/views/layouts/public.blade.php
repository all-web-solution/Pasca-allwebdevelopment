<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Pascasarjana IAIN Curup - Institusi Riset Keagamaan')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Academic Resmi Pascasarjana IAIN Curup. Menyelenggarakan program Magister (S2) unggulan, adaptif, inovatif, dan terintegrasi dengan penguatan ekosistem riset Islam kontemporer.')">
    <meta name="keywords" content="Pascasarjana, IAIN Curup, Magister, S2, Curup, Rejang Lebong, Bengkulu, Kuliah S2 Bengkulu, Pendidikan Agama Islam, Hukum Keluarga Islam, Manajemen Pendidikan Islam">
    <meta name="author" content="Pascasarjana IAIN Curup">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="@yield('title', 'Pascasarjana IAIN Curup - Institusi Riset Keagamaan')">
    <meta property="og:description" content="@yield('meta_description', 'Portal Academic Resmi Pascasarjana IAIN Curup. Menyelenggarakan program Magister (S2) unggulan, adaptif, dan inovatif.')">
    <meta property="og:image" content="@yield('meta_image', asset('img/bg-iain2.jpeg'))">
    <meta property="og:url" content="{{ url('#') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Pascasarjana IAIN Curup">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Pascasarjana IAIN Curup - Institusi Riset Keagamaan')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal Academic Resmi Pascasarjana IAIN Curup.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('img/bg-iain2.jpeg'))">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0A4D2E;
            --primary-rgb: 10, 77, 46;
            --accent: #10B981;
            --secondary: #ffffff;
            --dark: #0F172A;
            --light: #F8FAFC;
            --gray: #64748B;
            --card-bg: rgba(255, 255, 255, 0.8);
            --card-border: rgba(241, 245, 249, 0.8);
            --radius: 16px;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --footer-bg: #06311e;
        }

        [data-theme="dark"] {
            --dark: #F8FAFC;
            --light: #020617;
            --card-bg: rgba(15, 23, 42, 0.8);
            --card-border: rgba(30, 41, 59, 0.8);
            --gray: #94A3B8;
            --footer-bg: #090d16;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--light); color: var(--dark); overflow-x: hidden; transition: background-color 0.5s ease; display: flex; flex-direction: column; min-height: 100vh; }
        html { scroll-behavior: smooth; }
        .blob { position: absolute; width: 400px; height: 400px; background: rgba(16, 185, 129, 0.12); border-radius: 50%; filter: blur(80px); z-index: -1; pointer-events: none; }

        /* --- NAVBAR GLASSMORPHISM --- */
        nav { position: fixed; top: 20px; left: 5%; width: 90%; display: flex; justify-content: space-between; align-items: center; padding: 16px 4%; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 50px; border: 1px solid rgba(255, 255, 255, 0.3); z-index: 1000; transition: var(--transition); }
        [data-theme="dark"] nav { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); }
        nav.scrolled { top: 0; left: 0; width: 100%; border-radius: 0; background: var(--primary); border: none; }
        nav.scrolled .logo h1, nav.scrolled .nav-links a, nav.scrolled .action-btn i { color: #ffffff; }
        .logo h1 { font-size: 1.25rem; font-weight: 800; color: var(--primary); letter-spacing: -0.5px; }
        /* FIX: Menghapus position: relative di nav-right agar nav-links bisa melebar seukuran navbar */
        .nav-right { display: flex; align-items: center; gap: 24px; }
        .nav-links { display: flex; list-style: none; gap: 28px; transition: var(--transition); }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 600; font-size: 0.95rem; transition: var(--transition); }
        .nav-links a:hover { color: var(--accent); }
        .action-btn { cursor: pointer; font-size: 1.2rem; color: var(--primary); transition: var(--transition); }
        .menu-toggle { display: none; flex-direction: column; gap: 6px; cursor: pointer; z-index: 1001; }
        .menu-toggle span { width: 24px; height: 2px; background: var(--primary); transition: var(--transition); border-radius: 2px; }
        [data-theme="dark"] .menu-toggle span { background: var(--accent); }
        nav.scrolled .menu-toggle span { background: #ffffff; }

        /* --- GLOBAL APP SECTIONS & HERO --- */
        .hero { position: relative; height: 95vh; width: 100%; overflow: hidden; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transform: scale(1.05); transition: opacity 1.2s ease, transform 1.2s ease; display: flex; align-items: center; padding: 0 8%; }
        .slide.active { opacity: 1; transform: scale(1); }
        .slide::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(10, 77, 46, 0.92) 0%, rgba(15, 23, 42, 0.4) 100%); z-index: 1; }
        .slide-content { position: relative; z-index: 2; color: #ffffff; max-width: 680px; }
        .badge-hero { display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; background: rgba(255, 255, 255, 0.15); color: #ffffff; backdrop-filter: blur(5px); border-radius: 30px; font-size: 0.85rem; font-weight: 700; margin-bottom: 24px; border: 1px solid rgba(255, 255, 255, 0.2); }
        .slide-content h2 { font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; line-height: 1.15; letter-spacing: -1px; }
        .btn-modern { display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; background: var(--secondary); color: var(--primary); text-decoration: none; border-radius: 30px; font-weight: 700; border: none; cursor: pointer; transition: var(--transition); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .btn-modern:hover { transform: translateY(-3px); background: var(--accent); color: white; box-shadow: 0 15px 25px rgba(16, 185, 129, 0.3); }
        
        .stats-container { padding: 0 8%; margin-top: -60px; position: relative; z-index: 5; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; background: var(--card-bg); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 40px; border-radius: var(--radius); border: 1px solid var(--card-border); box-shadow: 0 20px 40px rgba(0,0,0,0.03); }
        .stat-item h3 { font-size: 2.8rem; font-weight: 800; color: var(--primary); }
        .stat-item p { color: var(--gray); font-size: 0.9rem; font-weight: 500; }

        section { padding: 100px 8% 60px; position: relative; }
        .section-header { text-align: center; max-width: 600px; margin: 0 auto 60px; }
        .section-header h2 { font-size: 2.5rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 12px; color: var(--primary); }
        [data-theme="dark"] .section-header h2 { color: #ffffff; }
        .section-header p { color: var(--gray); }

        /* --- MODERN MULTI-COLUMN FOOTER SYSTEM --- */
        footer.modern-app-footer {
            background-color: var(--footer-bg);
            color: #94A3B8;
            padding: 80px 8% 30px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
        .footer-grid-layout {
            display: grid;
            grid-template-columns: 1.5fr repeat(3, 1fr);
            gap: 48px;
            max-width: 1300px;
            margin: 0 auto;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .footer-block h3 { font-size: 1.35rem; font-weight: 800; color: #ffffff; margin-bottom: 20px; }
        .footer-block h4 { font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 24px; position: relative; }
        .footer-block h4::after { content: ''; position: absolute; left: 0; bottom: -8px; width: 30px; height: 2.5px; background-color: var(--accent); border-radius: 4px; }
        .footer-block p { font-size: 0.9rem; line-height: 1.625; color: #94A3B8; }
        .footer-block ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
        .footer-block ul li a { color: #94A3B8; text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
        .footer-block ul li a:hover { color: var(--accent); transform: translateX(4px); }
        .footer-contact-info { display: flex; flex-direction: column; gap: 16px; }
        .contact-item-box { display: flex; gap: 12px; font-size: 0.9rem; }
        .contact-item-box i { color: var(--accent); margin-top: 4px; }
        .footer-copyright-row { max-width: 1300px; margin: 30px auto 0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
        .footer-copyright-row p { font-size: 0.85rem; color: #64748B; }
        .footer-legal-links { display: flex; gap: 24px; }
        .footer-legal-links a { color: #64748B; text-decoration: none; font-size: 0.85rem; transition: var(--transition); }
        .footer-legal-links a:hover { color: var(--accent); }

        /* --- GLOBAL CUSTOM TOAST STYLING --- */
        #toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 9999; }
        .toast { background: #0F172A; color: #FFFFFF; padding: 14px 24px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; box-shadow: 0 10px 25px rgba(0,0,0,0.15); margin-top: 10px; transform: translateY(100px); opacity: 0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); display: flex; align-items: center; gap: 10px; }
        [data-theme="dark"] .toast { background: #FFFFFF; color: #0F172A; }
        .toast.show { transform: translateY(0); opacity: 1; }

        /* ========================================================================= */
        /* RESPONSIVE DESIGN UTAMA (ALL DEVICES) */
        /* ========================================================================= */
        @media (max-width: 992px) { 
            .footer-grid-layout { grid-template-columns: 1fr 1fr; gap: 32px; } 
            .nav-links { gap: 15px; }
            .nav-links a { font-size: 0.85rem; }
            .logo h1 { font-size: 1.15rem; }
            .slide-content h2 { font-size: 2.8rem; }
        }
        
        @media (max-width: 768px) { 
            /* PERBAIKAN NAVBAR MOBILE (FULL WIDTH & RAPI) */
            .menu-toggle { display: flex; }
            .nav-links {
                position: absolute; 
                top: calc(100% + 15px); /* Turun sedikit dari bawah navbar */
                left: 0; 
                width: 100%; /* Melebar 100% dari navbar */
                flex-direction: column; 
                background: var(--card-bg);
                backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px);
                padding: 25px; 
                border-radius: var(--radius);
                border: 1px solid var(--card-border);
                box-shadow: 0 20px 40px rgba(0,0,0,0.15);
                opacity: 0; 
                pointer-events: none; 
                transform: translateY(-15px);
                text-align: center; 
                gap: 20px;
                z-index: 999;
            }
            .nav-links.active { opacity: 1; pointer-events: auto; transform: translateY(0); }
            .nav-right { gap: 15px; }
            
            /* Perbaikan Font di Mobile */
            .slide-content h2 { font-size: 2.2rem; }
            .badge-hero { font-size: 0.75rem; }
            
            /* Perbaikan Toast Notifikasi Mobile */
            #toast-container { left: 20px; right: 20px; bottom: 20px; display: flex; flex-direction: column; align-items: center; }
            .toast { width: 100%; justify-content: center; text-align: center; }
        }
        
        @media (max-width: 576px) { 
            .footer-grid-layout { grid-template-columns: 1fr; gap: 40px; } 
            .footer-copyright-row { flex-direction: column; text-align: center; gap: 12px; } 
            .logo h1 { font-size: 1.05rem; }
            /* Menyesuaikan lebar padding luar untuk layar HP kecil */
            nav { padding: 16px 5%; width: 95%; left: 2.5%; }
            .btn-modern { width: 100%; justify-content: center; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="blob" style="top: 10%; left: -100px;"></div>
    <div class="blob" style="top: 60%; right: -100px; background: rgba(10, 77, 46, 0.1);"></div>

    <nav id="navbar">
        <div class="logo"><h1>PASCASARJANA</h1></div>
        <div class="nav-right">
            <ul class="nav-links" id="navLinks">
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ route('public.pendidikan') }}">Pendidikan</a></li>
                <li><a href="{{ route('public.penelitian') }}">Penelitian</a></li>
                <li><a href="{{ route('public.alumni') }}">Alumni</a></li>
                <li><a href="{{ route('public.dokumen') }}">Dokumen</a></li>
                <li><a href="{{ route('public.galeri') }}">Gallery</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
            <div class="action-btn" id="themeToggle"><i class="fa-solid fa-moon"></i></div>
            <div class="menu-toggle" id="menuToggle"><span></span><span></span></div>
        </div>
    </nav>

    <div style="flex: 1;">
        @yield('content')
    </div>

    <footer class="modern-app-footer">
        <div class="footer-grid-layout">
            <div class="footer-block">
                <h3>PASCASARJANA</h3>
                <p style="margin-bottom: 16px;">Institut Agama Islam Negeri Curup. Menyelenggarakan pendidikan magister berintegritas, inovatif, dan unggul dalam pengembangan riset keagamaan sosiologis religius kontemporer.</p>
                <p style="font-weight: 700; color: var(--accent);">Transformasi Digital & Mutu Riset.</p>
            </div>
            <div class="footer-block">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="/"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Beranda</a></li>
                    <li><a href="{{ route('public.pendidikan') }}"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Pendidikan</a></li>
                    <li><a href="{{ route('public.penelitian') }}"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Penelitian</a></li>
                    <li><a href="{{ route('public.alumni') }}"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Data Alumni</a></li>
                </ul>
            </div>
            <div class="footer-block">
                <h4>Akademik</h4>
                <ul>
                    <li><a href="{{ route('public.dokumen') }}"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Unduh Dokumen</a></li>
                    <li><a href="{{ route('login') }}"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> Portal SIAKAD</a></li>
                    <li><a href="#" onclick="event.preventDefault(); showToast('Menghubungkan ke E-Journal Hub...');"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> E-Journal Hub</a></li>
                    <li><a href="#" onclick="event.preventDefault(); showToast('Menghubungkan ke E-Library...');"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i> E-Library</a></li>
                </ul>
            </div>
            <div class="footer-block">
                <h4>Sekretariat</h4>
                <div class="footer-contact-info">
                    <div class="contact-item-box">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <p>Jl. Dr. AK Gani No. 01, Curup Tengah, Rejang Lebong, Bengkulu.</p>
                    </div>
                    <div class="contact-item-box">
                        <i class="fa-solid fa-envelope"></i>
                        <p>pasca@iaincurup.ac.id</p>
                    </div>
                    <div class="contact-item-box">
                        <i class="fa-solid fa-phone-volume"></i>
                        <p>+62 732 21544</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright-row">
            <p>&copy; 2026 Pascasarjana IAIN Curup. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="footer-legal-links">
                <a href="#" onclick="event.preventDefault();">Kebijakan Privasi</a>
                <a href="#" onclick="event.preventDefault();">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

    <div id="toast-container"></div>

    <script>
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `<i class="fa-solid fa-circle-check" style="margin-right:12px; color:var(--accent)"></i> ${message}`;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }

        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
            themeToggle.innerHTML = isDark ? '<i class="fa-solid fa-moon"></i>' : '<i class="fa-solid fa-sun"></i>';
            showToast(`Tema berhasil diubah ke mode ${isDark ? 'Terang' : 'Gelap'}`);
        });

        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if(window.scrollY > 40) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        
        // Logika toggle menu untuk mobile
        menuToggle.addEventListener('click', () => { 
            navLinks.classList.toggle('active'); 
        });

        // Menutup menu jika klik di luar navbar pada mode mobile
        document.addEventListener('click', function(event) {
            const nav = document.getElementById('navbar');
            if (!nav.contains(event.target) && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
            }
        });
    </script>
    @yield('scripts')

    <!-- ========================================================================= -->
    <!-- SECURE ACTIVE SESSION THROTTLING LOGOUT ENGINE -->
    <!-- ========================================================================= -->
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const idleTimeoutDuration = 15 * 60 * 1000; // Batas toleransi diam (15 Menit)
            let idleTimer;
            let lastResetTime = Date.now();

            function logoutUser() {
                if (typeof showToast === 'function') {
                    showToast("Sesi Anda telah berakhir karena tidak ada aktivitas.");
                }
                
                setTimeout(() => {
                    const logoutForm = document.createElement('form');
                    logoutForm.method = 'POST';
                    logoutForm.action = "{{ route('logout') }}";

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = "{{ csrf_token() }}";

                    logoutForm.appendChild(csrfInput);
                    document.body.appendChild(logoutForm);
                    logoutForm.submit();
                }, 1200);
            }

            function resetIdleTimer() {
                const now = Date.now();
                if (now - lastResetTime > 1000) { // Throttle pemanggilan per 1 detik
                    clearTimeout(idleTimer);
                    idleTimer = setTimeout(logoutUser, idleTimeoutDuration);
                    lastResetTime = now;
                }
            }

            const activityEvents = ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'];

            activityEvents.forEach(function(eventName) {
                window.addEventListener(eventName, resetIdleTimer, { passive: true });
            });

            clearTimeout(idleTimer);
            idleTimer = setTimeout(logoutUser, idleTimeoutDuration);
        });
    </script>
    @endauth
</body>
</html>