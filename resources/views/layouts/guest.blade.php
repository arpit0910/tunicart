<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tunicart') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800;900&display=swap" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <style>
            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                position: relative;
                overflow: hidden;
            }
            
            .auth-bg-glow {
                position: absolute;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
                filter: blur(80px);
                opacity: 0.15;
                z-index: -1;
            }
            
            .auth-card-custom {
                width: 100%;
                max-width: 450px;
                padding: 40px;
                border-radius: 24px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                animation: fadeInUp 0.6s ease-out;
            }
            
            .auth-logo {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .auth-logo h1 {
                font-size: 2.5rem;
                font-weight: 900;
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -1.5px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-label {
                display: block;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--text-color);
                margin-bottom: 8px;
            }
            
            .form-input {
                width: 100%;
                padding: 12px 16px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                color: var(--white);
                font-family: inherit;
                transition: var(--transition);
            }
            
            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                background: rgba(255, 255, 255, 0.08);
                box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
            }
            
            .auth-footer {
                margin-top: 25px;
                text-align: center;
                font-size: 0.9rem;
                color: var(--text-light);
            }
            
            .auth-footer a {
                color: var(--primary-color);
                font-weight: 600;
            }
            
            .auth-footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="auth-bg-glow" style="top: -100px; right: -100px;"></div>
            <div class="auth-bg-glow" style="bottom: -100px; left: -100px;"></div>
            
            <div class="auth-card-custom glass">
                <div class="auth-logo">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Tunicart Logo" style="height: 90px; width: auto; margin: 0 auto;">
                    </a>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

