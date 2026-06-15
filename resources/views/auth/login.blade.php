@extends('layouts.public')

@section('title', 'Portal Login - Pascasarjana IAIN Curup')

@section('styles')
<style>
    /* Wrapper Center dengan Background Blob Integration */
    .login-wrapper { 
        min-height: 85vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 60px 20px; 
        margin-top: 60px;
        position: relative;
    }
    
    /* Card Design Modern Glassmorphism */
    .login-card { 
        background: var(--card-bg); 
        border: 1px solid var(--card-border); 
        border-radius: 24px; 
        padding: 50px 45px; 
        width: 100%; 
        max-width: 460px; 
        backdrop-filter: blur(25px); 
        -webkit-backdrop-filter: blur(25px); 
        box-shadow: 0 25px 50px -12px rgba(10, 77, 46, 0.08);
        transition: var(--transition);
    }
    [data-theme="dark"] .login-card {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Header Form */
    .login-header { margin-bottom: 40px; text-align: center; }
    .login-header .icon-box {
        width: 64px;
        height: 64px;
        background: rgba(10, 77, 46, 0.08);
        color: var(--primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.8rem;
        transition: var(--transition);
    }
    [data-theme="dark"] .login-header .icon-box {
        background: rgba(16, 185, 129, 0.15);
        color: var(--accent);
    }
    .login-header h2 { font-size: 1.8rem; font-weight: 800; color: var(--dark); letter-spacing: -0.75px; }
    .login-header p { color: var(--gray); font-size: 0.9rem; margin-top: 8px; line-height: 1.5; }

    /* Input Group Container */
    .form-group-login { position: relative; margin-bottom: 24px; }
    .form-group-login i.input-icon { 
        position: absolute; 
        left: 18px; 
        top: 50%; 
        transform: translateY(-50%); 
        color: var(--gray); 
        font-size: 1.1rem;
        transition: var(--transition);
        pointer-events: none;
    }
    
    /* Input Fields */
    .form-group-login input { 
        width: 100%; 
        padding: 16px 16px 16px 52px; 
        border: 1.5px solid var(--card-border); 
        border-radius: 14px; 
        background: var(--light); 
        color: var(--dark); 
        outline: none; 
        font-size: 0.95rem; 
        font-weight: 500;
        transition: var(--transition); 
    }
    .form-group-login input:placeholder-shown { font-weight: 400; }
    
    /* Input Focus States */
    .form-group-login input:focus { 
        border-color: var(--primary); 
        background: var(--secondary);
        box-shadow: 0 0 0 4px rgba(10, 77, 46, 0.1);
    }
    .form-group-login input:focus ~ i.input-icon { color: var(--primary); }
    
    [data-theme="dark"] .form-group-login input:focus { 
        border-color: var(--accent); 
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
    }
    [data-theme="dark"] .form-group-login input:focus ~ i.input-icon { color: var(--accent); }

    /* Login Extra Options */
    .login-options { display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; margin-bottom: 32px; color: var(--gray); }
    .remember-me { display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; font-weight: 600; }
    .remember-me input { 
        width: 18px;
        height: 18px;
        accent-color: var(--primary); 
        cursor: pointer; 
        border-radius: 4px;
    }
    [data-theme="dark"] .remember-me input { accent-color: var(--accent); }

    /* Tombol Submit Utama */
    .btn-login { 
        width: 100%; 
        padding: 16px; 
        background: var(--primary); 
        color: white; 
        border: none; 
        border-radius: 14px; 
        font-weight: 700; 
        font-size: 1rem; 
        cursor: pointer; 
        transition: var(--transition); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 12px; 
        box-shadow: 0 10px 20px -5px rgba(10, 77, 46, 0.3); 
    }
    .btn-login:hover { background: var(--accent); transform: translateY(-2px); box-shadow: 0 15px 25px -5px rgba(16, 185, 129, 0.4); }
    .btn-login:active { transform: translateY(0); }

    /* Spinner Loading */
    .spinner { display: none; width: 22px; height: 22px; border: 3px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top-color: white; animation: spin 0.7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 480px) {
        .login-card { padding: 40px 24px; }
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="icon-box">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2>Portal Akademik</h2>
            <p>Masukkan NIM / NIDN beserta kata sandi yang telah terdaftar di database sistem</p>
        </div>

        <form id="loginForm">
            <!-- Input Identitas -->
            <div class="form-group-login">
                <input type="text" id="loginIdentity" placeholder="NIM / NIDN / Alamat Email" required autocomplete="username">
                <i class="fa-solid fa-user input-icon"></i>
            </div>

            <!-- Input Password -->
            <div class="form-group-login">
                <input type="password" id="loginPassword" placeholder="Kata Sandi Akun" required autocomplete="current-password">
                <i class="fa-solid fa-lock input-icon"></i>
            </div>

            <!-- Opsi Ingat Saya -->
            <div class="login-options">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <!-- Tombol Submit Form -->
            <button type="submit" class="btn-login" id="submitBtn">
                <span id="btnText">Masuk ke Sistem</span>
                <div class="spinner" id="btnSpinner"></div>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        
        const identity = document.getElementById('loginIdentity').value;
        const password = document.getElementById('loginPassword').value;
        const remember = document.getElementById('rememberMe').checked;

        // Kunci tombol dan hidupkan animasi loading
        submitBtn.style.pointerEvents = 'none';
        btnText.innerText = 'Memverifikasi Data Database...';
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
            btnText.innerText = 'Masuk ke Sistem';
            btnSpinner.style.display = 'none';
        }
    });
</script>
@endsection