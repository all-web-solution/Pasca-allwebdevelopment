@extends('layouts.public')

@section('title', 'Portal Login - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Variabel Warna Modern Konsisten */
    :root {
        --yellow-accent: #F59E0B;
        --yellow-light: rgba(245, 158, 11, 0.1);
        --primary-light: rgba(10, 77, 46, 0.08);
        --teal-accent: #0D9488;
        --card-shadow: 0 30px 60px -15px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 40px 80px -20px rgba(10, 77, 46, 0.2);
        --radius-xl: 28px;
        --smooth-transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Wrapper Center dengan Background Blob Integration */
    .login-wrapper { 
        min-height: 85vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 60px 20px; 
        margin-top: 40px;
        position: relative;
    }
    
    /* ================================================================= */
    /* UI MODERN: KARTU LOGIN APPLE STYLE */
    /* ================================================================= */
    .login-card { 
        background: #ffffff; 
        border: 1px solid rgba(0,0,0,0.03); 
        border-radius: var(--radius-xl); 
        padding: 50px; 
        width: 100%; 
        max-width: 480px; 
        box-shadow: var(--card-shadow);
        transition: var(--smooth-transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    [data-theme="dark"] .login-card { background: rgba(15, 23, 42, 0.75); border-color: rgba(255,255,255,0.05); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.5); }
    
    /* Watermark Icon di Background Kartu */
    .login-card::before {
        content: '\f3ed'; font-family: 'FontAwesome'; position: absolute;
        top: -30px; right: -30px; font-size: 200px; color: rgba(0,0,0,0.02);
        z-index: -1; transform: rotate(-15deg); transition: var(--smooth-transition);
    }
    [data-theme="dark"] .login-card::before { color: rgba(255,255,255,0.02); }
    .login-card:hover::before { transform: rotate(-5deg) scale(1.05); color: rgba(10, 77, 46, 0.03); }

    .login-card:hover { transform: translateY(-5px); box-shadow: var(--card-shadow-hover); }

    /* Header Form */
    .login-header { margin-bottom: 40px; text-align: center; }
    
    /* Ikon Box Premium */
    .login-header .icon-box {
        width: 75px; height: 75px; background: var(--primary-light); color: var(--primary);
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 2rem; transition: var(--smooth-transition);
    }
    .login-card:hover .icon-box { background: var(--primary); color: white; transform: scale(1.05) rotate(-5deg); border-radius: 50%; }
    
    .badge-login {
        display: inline-block; padding: 6px 14px; background: var(--yellow-light); color: var(--yellow-accent);
        font-size: 0.75rem; font-weight: 800; border-radius: 30px; margin-bottom: 15px; letter-spacing: 1px;
    }
    
    .login-header h2 { font-size: 2rem; font-weight: 800; color: var(--dark); letter-spacing: -1px; margin-bottom: 8px; }
    [data-theme="dark"] .login-header h2 { color: #F8FAFC; }
    .login-header p { color: var(--gray); font-size: 0.95rem; line-height: 1.6; }

    /* ================================================================= */
    /* UI MODERN: INPUT GROUPS */
    /* ================================================================= */
    .form-group-login { position: relative; margin-bottom: 24px; }
    .form-group-login i.input-icon { 
        position: absolute; left: 22px; top: 50%; transform: translateY(-50%); 
        color: var(--gray); font-size: 1.15rem; transition: var(--smooth-transition); pointer-events: none;
    }
    
    /* Toggle Show/Hide Password Icon */
    .toggle-password-icon {
        position: absolute; right: 22px; top: 50%; transform: translateY(-50%);
        color: var(--gray); font-size: 1.1rem; cursor: pointer; transition: var(--smooth-transition);
        padding: 5px;
    }
    .toggle-password-icon:hover { color: var(--primary); transform: translateY(-50%) scale(1.1); }
    [data-theme="dark"] .toggle-password-icon:hover { color: var(--yellow-accent); }

    .form-group-login input { 
        width: 100%; padding: 18px 55px 18px 55px; border: 1px solid rgba(0,0,0,0.06); 
        border-radius: 16px; background: var(--light); color: var(--dark); 
        outline: none; font-size: 0.95rem; font-weight: 600; transition: var(--smooth-transition); 
    }
    [data-theme="dark"] .form-group-login input { background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.05); color: white; }
    
    .form-group-login input:placeholder-shown { font-weight: 500; color: var(--gray); }
    
    /* Efek Focus Modern */
    .form-group-login input:focus { 
        background: #ffffff; border-color: var(--primary); 
        box-shadow: 0 10px 25px rgba(10, 77, 46, 0.08); transform: translateY(-2px);
    }
    .form-group-login input:focus ~ i.input-icon { color: var(--primary); }
    
    [data-theme="dark"] .form-group-login input:focus { 
        background: rgba(15, 23, 42, 0.9); border-color: var(--yellow-accent); 
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.1); 
    }
    [data-theme="dark"] .form-group-login input:focus ~ i.input-icon { color: var(--yellow-accent); }

    /* Extra Options */
    .login-options { display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; margin-bottom: 35px; color: var(--gray); }
    .remember-me { display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; font-weight: 600; transition: color 0.3s ease; }
    .remember-me:hover { color: var(--dark); }
    [data-theme="dark"] .remember-me:hover { color: white; }
    
    .remember-me input { 
        width: 20px; height: 20px; accent-color: var(--primary); 
        cursor: pointer; border-radius: 6px;
    }
    [data-theme="dark"] .remember-me input { accent-color: var(--yellow-accent); }

    /* Tombol Submit */
    .btn-login { 
        width: 100%; padding: 18px; background: var(--primary); color: white; 
        border: none; border-radius: 16px; font-weight: 800; font-size: 1.05rem; 
        cursor: pointer; transition: var(--smooth-transition); display: flex; 
        align-items: center; justify-content: center; gap: 12px; 
        box-shadow: 0 10px 20px rgba(10, 77, 46, 0.2); 
    }
    .btn-login:hover { background: var(--yellow-accent); transform: translateY(-3px); box-shadow: 0 15px 30px rgba(245, 158, 11, 0.25); color: white; }
    .btn-login:active { transform: translateY(0); box-shadow: 0 5px 10px rgba(245, 158, 11, 0.2); }

    /* Spinner Loading */
    .spinner { display: none; width: 22px; height: 22px; border: 3px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top-color: white; animation: spin 0.8s cubic-bezier(0.4, 0, 0.2, 1) infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 576px) {
        .login-card { padding: 40px 25px; border-radius: 24px; }
        .login-header h2 { font-size: 1.8rem; }
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="badge-login">
                <i class="fa-solid fa-lock" style="margin-right: 4px;"></i> SECURE LOGIN
            </div>
            <div class="icon-box">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2>Portal Akademik</h2>
            <p>Masukkan NIDN atau alamat email beserta kata sandi yang telah terdaftar di dalam sistem.</p>
        </div>

        <form id="loginForm">
            <!-- Input Identitas -->
            <div class="form-group-login">
                <input type="text" id="loginIdentity" placeholder="NIDN / Alamat Email" required autocomplete="username">
                <i class="fa-solid fa-user input-icon"></i>
            </div>

            <!-- Input Password dengan Toggle Show/Hide -->
            <div class="form-group-login">
                <input type="password" id="loginPassword" placeholder="Kata Sandi Akun" required autocomplete="current-password">
                <i class="fa-solid fa-key input-icon"></i>
                <i class="fa-solid fa-eye toggle-password-icon" id="togglePasswordBtn" title="Lihat Sandi"></i>
            </div>

            <!-- Opsi Ingat Saya -->
            <div class="login-options">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    <span>Ingat Sesi Saya</span>
                </label>
            </div>

            <!-- Tombol Submit Form -->
            <button type="submit" class="btn-login" id="submitBtn">
                <span id="btnText">Otorisasi Masuk <i class="fa-solid fa-arrow-right-to-bracket" style="margin-left: 6px;"></i></span>
                <div class="spinner" id="btnSpinner"></div>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fitur Toggle Show/Hide Password
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('loginPassword');

    togglePasswordBtn.addEventListener('click', function () {
        // Toggle tipe input antara password dan text
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle ikon mata (eye dan eye-slash)
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        
        // Ubah warna ikon saat sedang dilihat
        if(type === 'text') {
            this.style.color = 'var(--primary)';
        } else {
            this.style.color = 'var(--gray)';
        }
    });

    // Form Submit Fetch Logic
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        
        const identity = document.getElementById('loginIdentity').value;
        const password = passwordInput.value;
        const remember = document.getElementById('rememberMe').checked;

        // Kunci tombol dan hidupkan animasi loading
        submitBtn.style.pointerEvents = 'none';
        btnText.innerText = 'Memverifikasi...';
        btnSpinner.style.display = 'block';

        fetch("{{ route('login.submit') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                identity: identity,
                password: password,
                remember: remember
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message);
                setTimeout(() => {
                    window.location.href = "{{ route('admin.dashboard') }}";
                }, 1000);
            } else {
                showToast(data.message);
                resetButton();
            }
        })
        .catch(error => {
            showToast('Gagal mencocokkan data. Koneksi terputus atau kredensial tidak valid.');
            resetButton();
        });

        function resetButton() {
            submitBtn.style.pointerEvents = 'auto';
            btnText.innerHTML = 'Otorisasi Masuk <i class="fa-solid fa-arrow-right-to-bracket" style="margin-left: 6px;"></i>';
            btnSpinner.style.display = 'none';
        }
    });
</script>
@endsection