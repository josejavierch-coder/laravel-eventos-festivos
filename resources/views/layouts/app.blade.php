<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventosFestivos - Explora Tus Celebraciones')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <style>
        /* Precision Header Alignment to match design image */
        .landing-header {
            height: 90px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .landing-header.scrolled {
            height: 75px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
        }

        /* Vibrant Dynamic Backgrounds */
        .background-blobs {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background-color: #f8fafc;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            animation: float 20s infinite alternate;
        }

        .blob-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(38, 186, 157, 0.2) 0%, rgba(38, 186, 157, 0) 70%);
            top: -200px;
            right: -100px;
        }

        .blob-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(192, 40, 130, 0.15) 0%, rgba(192, 40, 130, 0) 70%);
            bottom: -100px;
            left: -100px;
        }

        .blob-3 {
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 70%);
            top: 40%;
            left: 20%;
        }

        @keyframes float {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, 50px) scale(1.1); }
        }

        .header-content {
            display: grid;
            grid-template-columns: auto 1fr auto; /* Logo | Nav (Centered) | Buttons */
            align-items: center;
            width: 100%;
            gap: 40px;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo-group:hover {
            transform: scale(1.02);
        }

        .logo-icon-img {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 3rem;
            line-height: 1;
            background: linear-gradient(135deg, #26ba9d 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-top: -5px;
        }

        .logo-text-img {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -0.8px;
            color: #0f172a;
        }

        .nav-menu-centered {
            display: flex;
            justify-content: center;
        }

        .nav-menu-centered ul {
            display: flex;
            list-style: none;
            gap: 40px;
            margin: 0;
            padding: 0;
        }

        .nav-menu-centered a {
            text-decoration: none;
            color: #475569;
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            padding: 8px 4px;
            transition: all 0.3s ease;
        }

        .nav-menu-centered a:hover, .nav-menu-centered a.active {
            color: #0f172a;
        }

        .nav-menu-centered a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(to right, #26ba9d, #3b82f6);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .nav-menu-centered a:hover::after, .nav-menu-centered a.active::after {
            width: 100%;
        }

        .header-actions-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-admin-access {
            background: linear-gradient(135deg, #26ba9d 0%, #c02882 100%);
            background-size: 200% auto;
            color: white !important;
            padding: 12px 28px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(38, 186, 157, 0.3);
            transition: all 0.4s ease;
        }

        .btn-admin-access:hover {
            background-position: right center;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 30px -5px rgba(38, 186, 157, 0.4);
        }

        #mobileMenuToggle {
            display: none;
            background: white;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            padding: 10px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #mobileMenuToggle:hover {
            background: #f8fafc;
            transform: rotate(90deg);
        }

        .mobile-nav {
            display: none;
            position: fixed;
            top: 100px;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            z-index: 999;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 1100px) {
            .header-content { gap: 20px; }
            .nav-menu-centered ul { gap: 25px; }
            .logo-text-img { font-size: 1.6rem; }
        }

        @media (max-width: 992px) {
            #mobileMenuToggle { display: block; }
            .nav-menu-centered { display: none; }
            .header-actions-group { display: none; }
            .landing-header { height: 80px; }
        }
    </style>
    @yield('styles')
</head>
<body class="landing-body">
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <header class="landing-header">
        <div class="container header-content">
            <a href="{{ route('home') }}" class="logo-group">
                <span class="logo-icon-img">E</span>
                <span class="logo-text-img">EventosFestivos</span>
            </a>
            
            <nav class="nav-menu-centered">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') && !request('categoria') ? 'active' : '' }}">Inicio</a></li>
                </ul>
            </nav>

            <div class="header-actions-group">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin-access">
                        <i data-lucide="unlock" size="18"></i> Dashboard <i data-lucide="unlock" size="18"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-admin-access">
                        <i data-lucide="lock" size="18"></i> Panel de Administración <i data-lucide="lock" size="18"></i>
                    </a>
                @endauth
            </div>

            <button id="mobileMenuToggle" onclick="toggleMobileNav()">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </header>

    <div id="mobileNav" class="mobile-nav">
        <ul style="display: flex; flex-direction: column; gap: 15px; list-style: none; padding: 0;">
            <li><a href="{{ route('home') }}" style="text-decoration: none; color: #1a202c; font-weight: 700; font-size: 1.1rem;">Inicio</a></li>
            <li><hr style="border: none; border-top: 1px solid #f1f5f9; margin: 10px 0;"></li>
            <li><a href="{{ route('login') }}" style="text-decoration: none; color: var(--color-teal); font-weight: 800;">Panel de Administración</a></li>
        </ul>
    </div>

    <main>
        @yield('content')
    </main>

    <footer style="background: white; padding: 60px 0; border-top: 1px solid #f1f5f9;">
        <div class="container" style="text-align: center;">
            <div class="logo-group" style="justify-content: center; margin-bottom: 20px;">
                <span class="logo-icon-img" style="font-size: 1.5rem;">E</span>
                <span class="logo-text-img" style="font-size: 1.5rem;">EventosFestivos</span>
            </div>
            <p style="color: #94a3b8; font-size: 0.9rem;">&copy; {{ date('Y') }} EventosFestivos. Diseñando momentos inolvidables.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.landing-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        function toggleMobileNav() {
            const nav = document.getElementById('mobileNav');
            nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
        }
        window.onclick = function(event) {
            if (!event.target.closest('#mobileNav') && !event.target.closest('#mobileMenuToggle')) {
                const nav = document.getElementById('mobileNav');
                if(nav) nav.style.display = 'none';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
