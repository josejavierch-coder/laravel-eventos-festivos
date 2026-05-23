@extends('layouts.app')

@section('title', 'EventosFestivos - Explora Tus Celebraciones')

@section('styles')
<style>
    /* Specific Hero Adjustments for Design Precision */
    .hero-title {
        font-size: 4.5rem;
        font-weight: 900;
        color: #0f172a;
        margin: 100px 0 60px;
        text-align: center;
        letter-spacing: -2px;
    }

    /* Slider Implementation */
    .upcoming-section {
        padding: 80px 0;
        text-align: center;
    }

    .upcoming-header {
        font-size: 1.8rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 50px;
        letter-spacing: 1px;
    }

    .slider-viewport {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 60px;
    }

    .slider-track-container {
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        gap: 25px;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .slider-card {
        flex: 0 0 calc(33.333% - 17px); /* 3 items exactly */
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
        text-align: left;
    }

    .slider-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .slider-card-body {
        padding: 20px;
    }

    .slider-card h4 {
        font-size: 0.6rem; /* Reduced to half (original was around 1.1rem) */
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .slider-card p {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
    }

    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .nav-arrow:hover {
        background: var(--color-teal);
        color: white;
        border-color: var(--color-teal);
    }

    .nav-arrow.left { left: 0; }
    .nav-arrow.right { right: 0; }

    @media (max-width: 1024px) {
        .slider-card { flex: 0 0 calc(50% - 13px); }
        .hero-title { font-size: 3rem; }
    }

    @media (max-width: 640px) {
        .slider-card { flex: 0 0 100%; }
        .slider-viewport { padding: 0 40px; }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="container">
        <h1 class="hero-title">Explora Tus Celebraciones</h1>
        
        <div class="category-grid">
            @php
                $cat_data = [
                    'cumpleanos' => ['icon' => '🎊', 'class' => 'card-teal', 'btn' => 'btn-teal', 'text' => 'Planificar Cumple'],
                    'matrimonios' => ['icon' => '💍', 'class' => 'card-orange', 'btn' => 'btn-orange', 'text' => 'Organizar Boda'],
                    'bautizos' => ['icon' => '🕊️', 'class' => 'card-blue', 'btn' => 'btn-blue', 'text' => 'Detallar Bautizo'],
                    'solo-fiestas' => ['icon' => '🎧', 'class' => 'card-pink', 'btn' => 'btn-pink', 'text' => 'Lanzar Fiesta']
                ];
            @endphp

            @foreach($categorias->take(4) as $categoria)
                @php
                    $slug = Str::slug($categoria->nombre);
                    $data = $cat_data[$slug] ?? ['icon' => '⭐', 'class' => 'card-teal', 'btn' => 'btn-teal', 'text' => 'Ver Eventos'];
                @endphp
                <div class="category-card {{ $data['class'] }}">
                    <div class="card-icon" style="font-size: 4.5rem; margin-bottom: 20px;">{{ $data['icon'] }}</div>
                    <h3 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin-bottom: 15px;">{{ $categoria->nombre }}</h3>
                    <p style="color: #64748b; margin-bottom: 35px; font-size: 1rem; line-height: 1.5;">{{ $categoria->descripcion }}</p>
                    <a href="{{ route('home', ['categoria' => $categoria->slug]) }}" class="btn {{ $data['btn'] }}" style="width:100%; justify-content:center; border-radius: 10px; padding: 14px;">
                        {{ $data['text'] }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Circular Slider Section -->
    <section class="upcoming-section" style="margin-top: 100px;">
        <div class="container">
            <h2 class="upcoming-header">Próximos Próximos | Próximos Próximos</h2>
            
            <div class="slider-viewport">
                <button class="nav-arrow left" id="btnLeft"><i data-lucide="chevron-left"></i></button>
                
                <div class="slider-track-container">
                    <div class="slider-track" id="track">
                        @foreach($proximos_eventos as $evento)
                            <div class="slider-item">
                                <div class="slider-card">
                                    <img src="{{ $evento->imagen_representativa ? asset('storage/' . $evento->imagen_representativa) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" alt="Evento">
                                    <div class="slider-card-body">
                                        <h4>{{ Str::limit($evento->titulo, 30) }}</h4>
                                        <p>📅 {{ $evento->fecha_evento ? $evento->fecha_evento->format('d M Y') : 'Próximamente' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="nav-arrow right" id="btnRight"><i data-lucide="chevron-right"></i></button>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('track');
        const cards = document.querySelectorAll('.slider-item');
        const btnLeft = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');
        
        if (!track || cards.length === 0) return;

        let index = 0;
        
        function getVisible() {
            if (window.innerWidth <= 640) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        function move() {
            const visible = getVisible();
            const width = cards[0].offsetWidth + 25; // width + gap
            track.style.transform = `translateX(-${index * width}px)`;
        }

        btnRight.addEventListener('click', () => {
            const visible = getVisible();
            if (index < cards.length - visible) {
                index++;
            } else {
                index = 0; // Back to start (circular)
            }
            move();
        });

        btnLeft.addEventListener('click', () => {
            const visible = getVisible();
            if (index > 0) {
                index--;
            } else {
                index = Math.max(0, cards.length - visible); // To end (circular)
            }
            move();
        });

        window.addEventListener('resize', move);
        lucide.createIcons();
    });
</script>
@endsection
