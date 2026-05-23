@extends('layouts.app')

@section('title', 'Detalles del Evento - ' . $evento->titulo)

@section('styles')
<!-- Fallback Tailwind CDN to ensure styles load if Vite build has issues -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    teal: {
                        50: '#f0fdfa',
                        100: '#ccfbf1',
                        200: '#99f6e4',
                        500: '#14b8a6',
                        600: '#0d9488',
                    }
                },
                borderRadius: {
                    '3xl': '1.5rem',
                    '4xl': '2rem',
                    '5xl': '2.5rem',
                }
            }
        }
    }
</script>
<style>
    /* Absolute precision styles to match the reference image exactly */
    .event-detail-container {
        font-family: 'Inter', sans-serif;
        background-color: transparent;
        min-height: 100vh;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 2rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03), 0 5px 15px rgba(0, 0, 0, 0.01);
    }

    .header-icon-container {
        width: 64px;
        height: 64px;
        background: #ccfbf1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d9488;
    }

    .data-key-icon {
        width: 56px;
        height: 56px;
        background: #f1f5f9;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        margin: 0 auto 12px;
    }

    .thumbnail-img-container {
        aspect-ratio: 4/3;
        border-radius: 1.25rem;
        overflow: hidden;
        border: 3px solid transparent;
        transition: all 0.3s ease;
        background: #f1f5f9;
    }

    .thumbnail-img-container:hover {
        border-color: #26ba9d;
        transform: scale(1.02);
    }

    .featured-media-container {
        aspect-ratio: 16/9;
        border-radius: 2rem;
        overflow: hidden;
        position: relative;
        background: #000;
        border: 1px solid #e2e8f0;
    }

    .client-comment-card {
        background: #f0fdfa;
        border-radius: 1.5rem;
        padding: 1.5rem;
        display: flex;
        gap: 1.25rem;
        align-items: center;
        border: 1px solid #ccfbf1;
    }

    .client-avatar {
        width: 72px;
        height: 72px;
        border-radius: 1rem;
        object-cover: cover;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Override any conflicting styles from style.css */
    .landing-body main {
        padding: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="event-detail-container pb-20 pt-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="flex flex-col md:flex-row items-center gap-6 mb-12">
            <div class="header-icon-container shadow-sm">
                @php
                    $icon = match(Str::slug($evento->categoria->nombre ?? '')) {
                        'cumpleanos' => 'party-popper',
                        'matrimonios' => 'heart',
                        'bautizos' => 'waves',
                        'fiestas' => 'music',
                        default => 'calendar'
                    };
                @endphp
                <i data-lucide="{{ $icon }}" style="width: 32px; height: 32px;"></i>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-extrabold text-[#1a202c] mb-2 tracking-tight">Detalles del Evento: {{ $evento->titulo }}</h1>
                <p class="text-lg md:text-xl text-gray-500 font-semibold">
                    {{ $evento->fecha_evento ? $evento->fecha_evento->format('d \d\e F, Y') : '15 de Julio, 2026' }} 
                    <span class="mx-2 opacity-30">|</span> 
                    {{ $evento->salon->nombre ?? 'Salón Sol' }} 
                    <span class="mx-2 opacity-30">|</span> 
                    Temática {{ $evento->tematica ?? 'Glamour' }}
                </p>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Sidebar -->
            <aside class="lg:col-span-4 flex flex-col gap-8">
                <!-- Summary & Comments Card -->
                <div class="glass-card p-10 flex flex-col h-full">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Resumen y Comentarios</h2>
                    <p class="text-gray-600 leading-relaxed text-lg mb-10">
                        {{ $evento->descripcion ?? 'Una celebración mágica llena de risas y alegría. El tema Glamour fue un éxito.' }}
                    </p>
                    
                    <div class="mt-auto">
                        <div class="client-comment-card">
                            <img src="{{ $evento->foto_cliente ?? 'https://i.pravatar.cc/150?u=sofia' }}" 
                                 alt="{{ $evento->nombre_cliente ?? 'Sofía' }}" 
                                 class="client-avatar">
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Comentarios de {{ $evento->nombre_cliente ?? 'Sofía' }}</h4>
                                <p class="text-gray-600 italic text-sm leading-snug">
                                    "{{ $evento->comentario_cliente ?? '¡El mejor cumpleaños de mi vida! Gracias por todo el apoyo.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Data Card -->
                <div class="glass-card p-10 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-10 text-left">Datos Clave</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <div class="data-key-icon">
                                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                            </div>
                            <span class="block text-2xl font-bold text-gray-900">{{ $evento->cantidad_invitados ?? 50 }}</span>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Invitados</p>
                        </div>
                        <div>
                            <div class="data-key-icon">
                                <i data-lucide="music" style="width: 24px; height: 24px;"></i>
                            </div>
                            <span class="block text-xl font-bold text-gray-900">{{ $evento->dj_set_list ?? 'DJ' }}</span>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-2">Set List</p>
                        </div>
                        <div>
                            <div class="data-key-icon">
                                <i data-lucide="cake" style="width: 24px; height: 24px;"></i>
                            </div>
                            <span class="block text-xl font-bold text-gray-900">{{ $evento->tarta ?? 'Tarta' }}</span>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-2">Astronómica</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Right Column: Main Content -->
            <main class="lg:col-span-8">
                <div class="glass-card p-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Galería Multimedia</h2>
                    
                    <!-- Featured Media Slider -->
                    @php
                        $todas_las_fotos = $evento->fotos->map(function($foto) {
                            return asset('storage/' . $foto->ruta);
                        })->toArray();
                        
                        if ($evento->imagen_representativa) {
                            array_unshift($todas_las_fotos, asset('storage/' . $evento->imagen_representativa));
                        }
                        $total_items = count($todas_las_fotos);
                    @endphp

                    <div class="featured-media-container mb-10 shadow-xl" id="galleryContainer">
                        <div id="galleryItems" class="h-full w-full relative">
                            @foreach($todas_las_fotos as $index => $ruta)
                                <div class="gallery-item absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                                    <img src="{{ $ruta }}" class="w-full h-full object-cover" alt="Foto {{ $index + 1 }}">
                                </div>
                            @endforeach
                            
                            @if($evento->video_destacado && $total_items === 0)
                                <div class="gallery-item absolute inset-0 opacity-100 z-10" data-index="0">
                                    <video class="w-full h-full object-cover" controls>
                                        <source src="{{ $evento->video_destacado }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Nav Buttons -->
                        @if($total_items > 1)
                        <div class="absolute inset-y-0 left-4 flex items-center z-20">
                            <button onclick="prevGalleryItem()" class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition-all">
                                <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-4 flex items-center z-20">
                            <button onclick="nextGalleryItem()" class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition-all">
                                <i data-lucide="chevron-right" style="width: 20px; height: 20px;"></i>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mb-10 px-2">
                        <h4 class="text-xl font-bold text-gray-900" id="galleryTitle">
                            Imagen Destacada: {{ $evento->titulo }}
                        </h4>
                        <div class="flex gap-2" id="galleryDots">
                            @foreach($todas_las_fotos as $index => $ruta)
                                <div class="gallery-dot w-2.5 h-2.5 rounded-full transition-colors cursor-pointer {{ $index === 0 ? 'bg-teal-500' : 'bg-gray-200' }}" onclick="goToGalleryItem({{ $index }})"></div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-4">
                        @foreach($todas_las_fotos as $index => $ruta)
                            <div class="flex flex-col gap-3 cursor-pointer group" onclick="goToGalleryItem({{ $index }})">
                                <div class="thumbnail-img-container shadow-sm {{ $index === 0 ? 'border-teal-500' : '' }}">
                                    <img src="{{ $ruta }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <p class="text-[9px] font-extrabold text-gray-500 text-center uppercase tracking-[0.1em] group-hover:text-teal-600">
                                    {{ ['Imagen 1', 'Imagen 2', 'Imagen 3', 'Imagen 4', 'Imagen 5', 'Imagen 6'][$index % 6] }}
                                </p>
                            </div>
                        @endforeach
                        
                        @if(count($todas_las_fotos) < 6)
                            @for($i = count($todas_las_fotos); $i < 6; $i++)
                                <div class="flex flex-col gap-3">
                                    <div class="thumbnail-img-container shadow-sm flex items-center justify-center bg-gray-50 opacity-50">
                                        <i data-lucide="image" class="text-gray-300"></i>
                                    </div>
                                    <p class="text-[9px] font-extrabold text-gray-500 text-center uppercase tracking-[0.1em]">Vacío</p>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Gallery State
    let currentGalleryIndex = 0;
    const galleryItems = document.querySelectorAll('.gallery-item');
    const galleryDots = document.querySelectorAll('.gallery-dot');
    const thumbContainers = document.querySelectorAll('.thumbnail-img-container');
    const totalItems = {{ count($todas_las_fotos) }};

    function updateGallery(newIndex) {
        if (totalItems <= 1) return;
        
        // Loop index
        if (newIndex >= totalItems) newIndex = 0;
        if (newIndex < 0) newIndex = totalItems - 1;
        
        // Hide current
        galleryItems[currentGalleryIndex].classList.replace('opacity-100', 'opacity-0');
        galleryItems[currentGalleryIndex].classList.replace('z-10', 'z-0');
        galleryDots[currentGalleryIndex].classList.replace('bg-teal-500', 'bg-gray-200');
        if (thumbContainers[currentGalleryIndex]) thumbContainers[currentGalleryIndex].classList.remove('border-teal-500');
        
        // Show new
        currentGalleryIndex = newIndex;
        galleryItems[currentGalleryIndex].classList.replace('opacity-0', 'opacity-100');
        galleryItems[currentGalleryIndex].classList.replace('z-0', 'z-10');
        galleryDots[currentGalleryIndex].classList.replace('bg-gray-200', 'bg-teal-500');
        if (thumbContainers[currentGalleryIndex]) thumbContainers[currentGalleryIndex].classList.add('border-teal-500');
    }

    function nextGalleryItem() { updateGallery(currentGalleryIndex + 1); }
    function prevGalleryItem() { updateGallery(currentGalleryIndex - 1); }
    function goToGalleryItem(index) { updateGallery(index); }

    // Re-initialize lucide icons
    lucide.createIcons();
</script>
@endsection
