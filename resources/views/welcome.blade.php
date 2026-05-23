<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventosFestivos - Organiza tus mejores momentos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
</head>
<body class="landing-body">
    <div class="background-blobs">
        <div class="blob blob-1"></div>
    </div>

    <header class="main-header">
        <div class="container header-content">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">E</div>
                <span class="logo-text">EventosFestivos</span>
            </a>
            
            <nav class="nav-menu">
                <ul>
                    <li><a href="#" class="active">Inicio</a></li>
                    <li><a href="#">Cómo Funciona</a></li>
                    <li><a href="#">Precios</a></li>
                    <li><a href="#">Soporte</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                        <i data-lucide="unlock"></i> Dashboard <i data-lucide="unlock"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-admin">
                        <i data-lucide="lock"></i> Acceso Admin <i data-lucide="lock"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero container">
            <h1 class="hero-title">Explora Tus Celebraciones</h1>
            
            <div class="category-grid">
                <div class="category-card">
                    <div class="card-icon">🎊</div>
                    <h3>Cumpleaños</h3>
                    <p>Fiestas temáticas, tortas y diversión para todas las edades.</p>
                    <a href="#" class="btn btn-teal">Planificar Cumple</a>
                </div>
                <div class="category-card">
                    <div class="card-icon">❤️</div>
                    <h3>Matrimonios</h3>
                    <p>Bodas de ensueño, catering exclusivo y momentos mágicos.</p>
                    <a href="#" class="btn btn-orange">Organizar Boda</a>
                </div>
                <div class="category-card">
                    <div class="card-icon">🌊</div>
                    <h3>Bautizos</h3>
                    <p>Ceremonias íntimas, recuerdos especiales y ambiente familiar.</p>
                    <a href="#" class="btn btn-blue">Detallar Bautizo</a>
                </div>
                <div class="category-card">
                    <div class="card-icon">🎵</div>
                    <h3>Solo Fiestas</h3>
                    <p>Eventos corporativos, aniversarios y noches de baile.</p>
                    <a href="#" class="btn btn-pink">Lanzar Fiesta</a>
                </div>
            </div>
        </section>

        <section class="container" style="padding-bottom: 100px;">
            <h2 class="section-title">PRÓXIMOS EVENTOS</h2>
            <div class="events-grid">
                @php
                    $eventos_demo = \App\Models\EventoFestivo::with('salon')->where('estado', true)->latest()->take(4)->get();
                @endphp
                
                @forelse($eventos_demo as $evento)
                    <div class="event-card">
                        <div style="height: 220px; background: #f8fafc;">
                            <img src="{{ $evento->imagen_representativa ? asset('storage/' . $evento->imagen_representativa) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="padding: 25px;">
                            <h4 style="margin-bottom: 12px; color: #0f172a; font-size: 1.2rem; font-weight: 800;">{{ Str::limit($evento->titulo, 30) }}</h4>
                            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                📍 {{ $evento->salon->nombre ?? 'Ubicación' }}
                            </p>
                            <p style="font-size: 0.9rem; color: #64748b; display: flex; align-items: center; gap: 8px;">
                                📅 {{ $evento->fecha_evento ? $evento->fecha_evento->format('d/m/Y') : 'Próximamente' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; grid-column: 1/-1; color: #94a3b8; font-style: italic;">Descubriendo nuevos eventos para ti...</p>
                @endforelse
            </div>
        </section>
    </main>

    <footer style="background: #ffffff; padding: 60px 0; border-top: 1px solid #f1f5f9;">
        <div class="container" style="text-align: center;">
            <div class="logo" style="justify-content: center; margin-bottom: 20px;">
                <div class="logo-icon" style="width: 30px; height: 30px; font-size: 1.1rem; background: none; color: #1e293b;">E</div>
                <span class="logo-text" style="font-size: 1.1rem;">EventosFestivos</span>
            </div>
            <p style="color: #94a3b8; font-size: 0.9rem;">&copy; {{ date('Y') }} EventosFestivos. Creamos momentos que duran para siempre.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>