<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console - Pascasarjana IAIN Curup')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0A4D2E;
            --primary-light: rgba(10, 77, 46, 0.08);
            --accent: #10B981;
            --dark: #0F172A;
            --light: #F8FAFC;
            --border-color: #E2E8F0;
            --card-bg: #ffffff;
            --text-main: #334155;
            --text-muted: #64748B;
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --dark: #F8FAFC;
            --light: #0B0F19;
            --border-color: #1E293B;
            --card-bg: #111827;
            --text-main: #CBD5E1;
            --text-muted: #94A3B8;
            --primary-light: rgba(16, 185, 129, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--light); color: var(--text-main); overflow-x: hidden; display: flex; min-height: 100vh; }

        /* --- FIXED SIDEBAR SYSTEM --- */
        aside.main-admin-sidebar {
            width: 280px; background: var(--card-bg); border-right: 1px solid var(--border-color);
            position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; display: flex; flex-direction: column;
        }
        .sidebar-identity { padding: 30px 24px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px; }
        .avatar-wrapper { width: 48px; height: 48px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; }
        [data-theme="dark"] .avatar-wrapper { color: var(--accent); }
        .identity-text h4 { font-size: 0.95rem; font-weight: 700; }
        .identity-text span { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }
        .sidebar-navigation-menu { padding: 24px 16px; list-style: none; display: flex; flex-direction: column; gap: 6px; }
        .menu-link-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: var(--text-muted); font-size: 0.9rem; font-weight: 600; border-radius: 8px; transition: var(--transition); }
        .menu-link-item.active a, .menu-link-item a:hover { background: var(--primary-light); color: var(--primary); }
        [data-theme="dark"] .menu-link-item.active a, [data-theme="dark"] .menu-link-item a:hover { color: var(--accent); }

        /* --- VIEWPORT ENGINE --- */
        .admin-viewport { margin-left: 280px; flex: 1; display: flex; flex-direction: column; min-width: 0; }
        header.admin-navbar { height: 70px; background: var(--card-bg); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; padding: 0 40px; position: sticky; top: 0; z-index: 90; }
        .topbar-brand h1 { font-size: 1.15rem; font-weight: 800; color: var(--primary); letter-spacing: -0.3px; }
        [data-theme="dark"] .topbar-brand h1 { color: var(--accent); }
        .topbar-actions { display: flex; align-items: center; gap: 16px; }
        .theme-control-btn { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-muted); border: 1px solid var(--border-color); }
        .admin-page-body { padding: 40px; flex: 1; }

        /* --- PROFESSIONAL UI CONTAINER CARD --- */
        .control-container-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius); margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; }
        .card-panel-heading { padding: 24px 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .card-panel-heading h3 { font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        
        /* --- GRID FORM LABELS & INPUTS --- */
        .panel-form-body { padding: 30px; }
        .form-flex-row { display: flex; gap: 24px; margin-bottom: 24px; flex-wrap: wrap; }
        .form-input-cell { flex: 1; min-width: 280px; display: flex; flex-direction: column; gap: 8px; }
        .form-input-cell label { font-size: 0.85rem; font-weight: 700; color: var(--text-main); }
        .form-input-cell input, .form-input-cell select, .form-input-cell textarea { width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 8px; background: var(--light); color: var(--text-main); outline: none; font-size: 0.9rem; transition: var(--transition); }
        .form-input-cell input:focus, .form-input-cell textarea:focus { border-color: var(--primary); background: var(--card-bg); }
        [data-theme="dark"] .form-input-cell input:focus, [data-theme="dark"] .form-input-cell textarea:focus { border-color: var(--accent); }

        /* --- PREMIUM TABLE VIEW --- */
        .tabular-view-shell { overflow-x: auto; }
        .clean-data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .clean-data-table th { background: var(--light); padding: 16px 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-color); color: var(--text-muted); }
        .clean-data-table td { padding: 18px 30px; border-bottom: 1px solid var(--border-color); }
        .clean-data-table tr:last-child td { border-bottom: none; }

        /* --- INTERACTION TOOLKIT --- */
        #toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 9999; }
        .toast { background: #0F172A; color: #FFFFFF; padding: 14px 24px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; box-shadow: 0 10px 25px rgba(0,0,0,0.15); margin-top: 10px; transform: translateY(100px); opacity: 0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); display: flex; align-items: center; gap: 10px; }
        [data-theme="dark"] .toast { background: #FFFFFF; color: #0F172A; }
        .toast.show { transform: translateY(0); opacity: 1; }

        .badge-status { padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
        .status-success { background: rgba(16, 185, 129, 0.12); color: #059669; }
        .status-warning { background: rgba(245, 158, 11, 0.12); color: #D97706; }

        .btn-modern { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; transition: var(--transition); }
        .btn-modern:hover { background: var(--accent); transform: translateY(-1px); }
        .btn-action-trigger { padding: 6px 14px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--card-bg); cursor: pointer; font-size: 0.8rem; font-weight: 600; transition: var(--transition); }
        .btn-action-trigger.delete-type { color: #DC2626; }
        .btn-action-trigger.delete-type:hover { background: #DC2626; color: white; border-color: #DC2626; }
    </style>
    @yield('styles')
</head>
<body>

    <aside class="main-admin-sidebar">
        <div class="sidebar-identity">
            <div class="avatar-wrapper"><i class="fa-solid fa-user-gear"></i></div>
            <div class="identity-text">
                <h4>Super Admin</h4>
                <span>Administrator Panel</span>
            </div>
        </div>
        <ul class="sidebar-navigation-menu">
             <li class="menu-link-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-graduation-cap"></i>Dashboard</a>
            </li>
            <li class="menu-link-item {{ Request::is('admin/pendidikan*') ? 'active' : '' }}">
                <a href="{{ route('admin.pendidikan') }}"><i class="fa-solid fa-graduation-cap"></i> Kontrol Pendidikan</a>
            </li>
            <li class="menu-link-item {{ Request::is('admin/berita*') ? 'active' : '' }}">
                <a href="{{ route('admin.berita') }}"><i class="fa-solid fa-newspaper"></i> Manajemen Berita</a>
            </li>
            <li class="menu-link-item {{ Request::is('admin/arsip*') ? 'active' : '' }}">
                <a href="{{ route('admin.arsip') }}">
                    <i class="fa-solid fa-box-archive"></i> Pusat Arsip & Media
                </a>
            </li>
            <li class="menu-link-item" style="margin-top: 30px;">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #DC2626;">
                    <i class="fa-solid fa-power-off"></i> Keluar Sistem
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </aside>

    <div class="admin-viewport">
        <header class="admin-navbar">
            <div class="topbar-brand">
                <h1>@yield('page_title', 'Sistem Kendali Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                <div class="theme-control-btn" id="adminThemeToggle"><i class="fa-solid fa-moon"></i></div>
            </div>
        </header>

        <main class="admin-page-body">
            @yield('content')
        </main>
    </div>

    <div id="toast-container"></div>

    <script>
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `<i class="fa-solid fa-circle-check" style="color:#10B981"></i> ${message}`;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 50);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }

        const adminThemeToggle = document.getElementById('adminThemeToggle');
        adminThemeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
            adminThemeToggle.innerHTML = isDark ? '<i class="fa-solid fa-moon"></i>' : '<i class="fa-solid fa-sun"></i>';
            showToast(`Sistem dialihkan ke ${isDark ? 'Mode Terang' : 'Mode Gelap'}`);
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