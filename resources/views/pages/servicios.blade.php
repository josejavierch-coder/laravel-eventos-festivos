@extends('layouts.app')

@section('title', 'Explorar Eventos - EventosFestivos')

@section('styles')
<style>
    .explorar-container {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 40px;
        padding-top: 50px;
        padding-bottom: 100px;
    }
    
    .sidebar-filters {
        background: white;
        padding: 35px;
        border-radius: 28px;
        box-shadow: 0 15px 40px rgba(15, 23, 42, 0.04);
        border: 2px solid #e2e8f0;
        height: fit-content;
        position: sticky;
        top: 130px;
    }

    .filter-group {
        margin-bottom: 35px;
    }

    .filter-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 20px;
        display: block;
        opacity: 0.8;
    }

    .filter-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .filter-link {
        color: #475569;
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        border-radius: 12px;
    }

    .filter-link:hover {
        background: #f8fafc;
        color: var(--color-blue);
    }

    .filter-link.active {
        background: var(--color-blue);
        color: white;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
    }

    .search-box {
        position: relative;
        margin-bottom: 35px;
    }

    .search-box input {
        width: 100%;
        padding: 14px 15px 14px 45px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: white;
        font-weight: 600;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: var(--color-blue);
        outline: none;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    /* Event Card Compact Square Style */
    .event-card-compact {
        background: #ffffff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 2px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        aspect-ratio: 1 / 1.1;
    }

    .event-card-compact:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
        border-color: var(--color-blue);
    }

    .event-card-img-container {
        height: 55%;
        position: relative;
        overflow: hidden;
    }

    .event-card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .event-card-compact:hover .event-card-img-container img {
        transform: scale(1.1);
    }

    .event-card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .event-card-tag {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        color: var(--color-blue);
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .event-card-title {
        color: #0f172a;
        font-size: 1.1rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .event-card-meta {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .btn-view-experience {
        margin-top: 15px;
        padding: 10px;
        border-radius: 12px;
        background: #f1f5f9;
        color: var(--color-blue);
        font-weight: 800;
        text-align: center;
        transition: 0.3s;
        font-size: 0.85rem;
    }

    .event-card-compact:hover .btn-view-experience {
        background: var(--color-blue);
        color: white;
    }

    @media (max-width: 992px) {
        .explorar-container { grid-template-columns: 1fr; }
        .sidebar-filters { position: static; }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="explorar-container">
            <!-- Sidebar Filtros -->
            <aside class="sidebar-filters">
                <form action="{{ route('home') }}" method="GET" id="filterForm">
                    <div class="search-box">
                        <i data-lucide="search" size="20"></i>
                        <input type="text" name="search" placeholder="¿Qué buscas hoy?" value="{{ request('search') }}">
                    </div>

                    <div class="filter-group">
                        <span class="filter-title">Categorías</span>
                        <ul class="filter-list">
                            <li>
                                <a href="{{ route('home') }}" class="filter-link {{ !request('categoria') ? 'active' : '' }}">
                                    <span>Todo</span>
                                </a>
                            </li>
                            @foreach($categorias as $cat)
                                <li>
                                    <a href="{{ route('home', ['categoria' => $cat->slug, 'salon' => request('salon'), 'search' => request('search')]) }}" 
                                       class="filter-link {{ request('categoria') == $cat->slug ? 'active' : '' }}">
                                        <span>{{ $cat->nombre }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="filter-group">
                        <span class="filter-title">Ubicación</span>
                        <select name="salon" onchange="this.form.submit()" style="width: 100%; padding: 12px; border-radius: 12px; border: 2px solid #e2e8f0; font-weight: 700;">
                            <option value="">Todos los locales</option>
                            @foreach($salones as $sal)
                                <option value="{{ $sal->id }}" {{ request('salon') == $sal->id ? 'selected' : '' }}>{{ $sal->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(request('categoria') || request('salon') || request('search'))
                        <a href="{{ route('home') }}" style="color: #ef4444; font-size: 0.85rem; font-weight: 800; text-align: center; display: block; margin-top: 20px;">
                             Limpiar Filtros
                        </a>
                    @endif
                </form>
            </aside>

            <!-- Grid de Eventos -->
            <section>
                <div style="margin-bottom: 40px;">
                    <h2 style="font-size: 2.2rem; font-weight: 900; color: #0f172a; margin-bottom: 5px;">
                        @if(request('categoria'))
                            {{ $categorias->where('slug', request('categoria'))->first()->nombre ?? 'Eventos' }}
                        @else
                            Explora Momentos
                        @endif
                    </h2>
                    <p style="color: #64748b; font-weight: 600;">{{ $eventos->total() }} experiencias encontradas</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
                    @forelse($eventos as $evento)
                        <div class="event-card-compact">
                            <div class="event-card-img-container">
                                <img src="{{ $evento->imagen_representativa ? asset('storage/' . $evento->imagen_representativa) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" alt="Evento">
                            </div>
                            <div class="event-card-content">
                                <div>
                                    <div class="event-card-tag">{{ $evento->categoria->nombre ?? 'Especial' }}</div>
                                    <h4 class="event-card-title">{{ Str::limit($evento->titulo, 40) }}</h4>
                                </div>
                                <div class="event-card-meta">
                                    <span>📍 {{ $evento->salon->nombre ?? 'Premium' }}</span>
                                    <span>📅 {{ $evento->fecha_evento ? $evento->fecha_evento->format('d/m/Y') : 'Próximamente' }}</span>
                                </div>
                                <a href="{{ route('eventos.show.public', $evento->slug) }}" class="btn-view-experience">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 100px 0;">
                             <h3>No hay eventos para esta selección.</h3>
                        </div>
                    @endforelse
                </div>

                <div class="pagination-container" style="margin-top: 60px;">
                    {{ $eventos->links() }}
                </div>
            </section>
        </div>
    </div>
@endsection
