<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fixly') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', 'Segoe UI', system-ui, -apple-system, sans-serif;
                background: #f0f6fe;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .fixly-auth-container {
                max-width: 1100px;
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0;
                background: #ffffff;
                border-radius: 28px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(10, 75, 122, 0.15);
                border: 1px solid rgba(10, 75, 122, 0.08);
                min-height: 560px;
            }

            /* ===== LEFT SIDE - BRAND ===== */
            .fixly-brand-side {
                background: linear-gradient(135deg, #0a4b7a 0%, #1c6ea4 100%);
                padding: 50px 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

            .fixly-brand-side::before {
                content: '';
                position: absolute;
                top: -100px;
                right: -100px;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
                border-radius: 50%;
            }

            .fixly-brand-side::after {
                content: '';
                position: absolute;
                bottom: -80px;
                left: -80px;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
                border-radius: 50%;
            }

            .fixly-brand-side .logo-section {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 30px;
                position: relative;
                z-index: 1;
            }

            .fixly-brand-side .logo-icon {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                background: rgba(255,255,255,0.15);
                backdrop-filter: blur(8px);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                color: #ffffff;
                border: 1px solid rgba(255,255,255,0.1);
                flex-shrink: 0;
            }

            .fixly-brand-side .logo-text h1 {
                font-size: 32px;
                font-weight: 700;
                color: #ffffff;
                letter-spacing: -0.5px;
            }

            .fixly-brand-side .logo-text h1 span {
                color: #f8b803;
            }

            .fixly-brand-side .logo-text .sub {
                font-size: 13px;
                color: rgba(255,255,255,0.7);
                font-weight: 400;
                display: block;
                margin-top: -2px;
            }

            .fixly-brand-side .brand-content {
                position: relative;
                z-index: 1;
            }

            .fixly-brand-side .brand-content h2 {
                font-size: 28px;
                font-weight: 700;
                color: #ffffff;
                line-height: 1.3;
                margin-bottom: 16px;
            }

            .fixly-brand-side .brand-content p {
                font-size: 15px;
                color: rgba(255,255,255,0.8);
                line-height: 1.7;
                max-width: 380px;
            }

            .fixly-brand-side .brand-features {
                margin-top: 28px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                position: relative;
                z-index: 1;
            }

            .fixly-brand-side .brand-features .feature-item {
                display: flex;
                align-items: center;
                gap: 12px;
                color: rgba(255,255,255,0.9);
                font-size: 14px;
            }

            .fixly-brand-side .brand-features .feature-item i {
                width: 22px;
                height: 22px;
                background: rgba(255,255,255,0.15);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 11px;
                color: #f8b803;
                flex-shrink: 0;
            }

            .fixly-brand-side .floating-icons {
                position: absolute;
                color: rgba(255,255,255,0.06);
                font-size: 80px;
                z-index: 0;
            }

            .fixly-brand-side .floating-icons:nth-child(2) { bottom: 60px; right: 20px; font-size: 100px; }
            .fixly-brand-side .floating-icons:nth-child(3) { top: 80px; right: 30px; font-size: 60px; }

            /* ===== RIGHT SIDE - FORM ===== */
            .fixly-form-side {
                padding: 50px 45px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                background: #ffffff;
                position: relative;
            }

            .fixly-form-side .form-header {
                margin-bottom: 28px;
            }

            .fixly-form-side .form-header h3 {
                font-size: 24px;
                font-weight: 700;
                color: #0a2e4a;
                margin-bottom: 4px;
            }

            .fixly-form-side .form-header p {
                font-size: 14px;
                color: #6b8aa3;
            }

            .fixly-form-side .form-header p a {
                color: #0a4b7a;
                font-weight: 600;
                text-decoration: none;
            }

            .fixly-form-side .form-header p a:hover {
                text-decoration: underline;
            }

            /* ===== FORM STYLES ===== */
            .fixly-form-side .form-group {
                margin-bottom: 18px;
            }

            .fixly-form-side .form-group label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #1f4b6e;
                margin-bottom: 5px;
            }

            .fixly-form-side .form-group label .required {
                color: #e74c3c;
            }

            .fixly-form-side .form-group .input-wrapper {
                position: relative;
            }

            .fixly-form-side .form-group .input-wrapper i {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #8aaec6;
                font-size: 16px;
            }

            .fixly-form-side .form-group input {
                width: 100%;
                padding: 12px 16px 12px 44px;
                border: 2px solid #e2ecf5;
                border-radius: 12px;
                font-size: 14px;
                color: #0a2e4a;
                background: #f8fbfe;
                transition: 0.2s ease;
                outline: none;
            }

            .fixly-form-side .form-group input:focus {
                border-color: #0a4b7a;
                background: #ffffff;
                box-shadow: 0 0 0 4px rgba(10, 75, 122, 0.08);
            }

            .fixly-form-side .form-group input::placeholder {
                color: #a8c0d2;
            }

            .fixly-form-side .form-group .error-text {
                font-size: 12px;
                color: #e74c3c;
                margin-top: 4px;
                display: block;
            }

            /* ===== REMEMBER ME & FORGOT ===== */
            .fixly-form-side .form-options {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 16px 0 22px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .fixly-form-side .form-options .remember-me {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 13px;
                color: #4a6e8a;
                cursor: pointer;
            }

            .fixly-form-side .form-options .remember-me input[type="checkbox"] {
                width: 18px;
                height: 18px;
                accent-color: #0a4b7a;
                border-radius: 4px;
                border: 2px solid #b6d0e3;
                cursor: pointer;
                flex-shrink: 0;
            }

            .fixly-form-side .form-options .forgot-link {
                font-size: 13px;
                color: #0a4b7a;
                text-decoration: none;
                font-weight: 500;
            }

            .fixly-form-side .form-options .forgot-link:hover {
                text-decoration: underline;
            }

            /* ===== BUTTONS ===== */
            .fixly-form-side .form-actions {
                display: flex;
                align-items: center;
                gap: 14px;
                flex-wrap: wrap;
            }

            .fixly-form-side .form-actions .btn-login {
                flex: 1;
                padding: 14px 28px;
                background: #0a4b7a;
                color: #ffffff;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                box-shadow: 0 4px 16px rgba(10, 75, 122, 0.25);
                min-width: 140px;
            }

            .fixly-form-side .form-actions .btn-login:hover {
                background: #073a5e;
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(10, 75, 122, 0.35);
            }

            .fixly-form-side .form-actions .btn-login:active {
                transform: translateY(0);
            }

            .fixly-form-side .form-actions .btn-register {
                padding: 14px 24px;
                background: transparent;
                color: #0a4b7a;
                border: 2px solid #b6d0e3;
                border-radius: 12px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: 0.2s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
            }

            .fixly-form-side .form-actions .btn-register:hover {
                background: #e6f0fa;
                border-color: #0a4b7a;
            }

            /* ===== SESSION STATUS ===== */
            .fixly-form-side .session-status {
                padding: 12px 16px;
                background: #d4edda;
                border: 1px solid #b7dfb7;
                border-radius: 10px;
                color: #155724;
                font-size: 14px;
                margin-bottom: 18px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .fixly-form-side .session-status i {
                font-size: 16px;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 820px) {
                .fixly-auth-container {
                    grid-template-columns: 1fr;
                    max-width: 480px;
                    min-height: auto;
                }

                .fixly-brand-side {
                    padding: 35px 30px;
                    border-radius: 28px 28px 0 0;
                }

                .fixly-brand-side .brand-content h2 {
                    font-size: 22px;
                }

                .fixly-brand-side .brand-content p {
                    max-width: 100%;
                }

                .fixly-form-side {
                    padding: 32px 28px;
                }

                .fixly-form-side .form-actions {
                    flex-direction: column;
                }

                .fixly-form-side .form-actions .btn-login,
                .fixly-form-side .form-actions .btn-register {
                    width: 100%;
                    justify-content: center;
                }

                .fixly-form-side .form-options {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }

            @media (max-width: 480px) {
                .fixly-brand-side {
                    padding: 28px 20px;
                }

                .fixly-brand-side .logo-text h1 {
                    font-size: 26px;
                }

                .fixly-brand-side .brand-content h2 {
                    font-size: 20px;
                }

                .fixly-form-side {
                    padding: 24px 18px;
                }

                .fixly-form-side .form-header h3 {
                    font-size: 20px;
                }

                .fixly-form-side .form-group input {
                    padding: 10px 14px 10px 38px;
                    font-size: 13px;
                }
            }
        </style>
    </head>
    <body>
        <div class="fixly-auth-container">
            <!-- LEFT SIDE - Brand -->
            <div class="fixly-brand-side">
                <i class="fas fa-server floating-icons"></i>
                <i class="fas fa-microchip floating-icons"></i>
                
                <div class="logo-section">
                    <div class="logo-icon">
                        <img src="{{ asset('images/tes.png') }}" style="width:70px;height:70px;object-fit:contain;">
                    </div>
                    <div class="logo-text">
                        <h1>Fixly<span>.</span></h1>
                        <span class="sub"><i class="fas fa-check-circle" style="font-size:11px;"></i> Manajemen Servis IT <br> SMK Negeri 2 PADANG PANJANG</span>
                    </div>
                </div>

                <div class="brand-content">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Kelola laporan servis dan perbaikan perangkat IT dengan mudah, cepat, dan terintegrasi.</p>
                    
                    <div class="brand-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Pantau status perbaikan secara real-time</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Kelola laporan kerusakan dengan mudah</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Riwayat servis lengkap dan terorganisir</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - Form -->
            <div class="fixly-form-side">
                <div class="form-header">
                    <h3>Masuk ke Akun</h3>
                    <p>
                        Belum punya akun? 
                        <a href="{{ route('register') }}">Daftar sekarang</a>
                    </p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>