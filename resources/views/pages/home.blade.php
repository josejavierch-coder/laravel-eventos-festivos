@extends('layouts.app')

@section('title', 'EventosFestivos - Explora Tus Celebraciones')

@section('content')
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Explora Tus Celebraciones</h1>
            
            <div class="category-grid">
                <x-category-card 
                    color="teal" 
                    icon="party-popper" 
                    title="Cumpleaños" 
                    description="Fiestas temáticas, tortas y diversión para todas las edades."
                    buttonText="Planificar Cumple"
                />

                <x-category-card 
                    color="orange" 
                    icon="heart" 
                    title="Matrimonios" 
                    description="Bodas de ensueño, catering exclusivo y momentos mágicos."
                    buttonText="Organizar Boda"
                />

                <x-category-card 
                    color="blue" 
                    icon="waves" 
                    title="Bautizos" 
                    description="Ceremonias íntimas, recuerdos especiales y ambiente familiar."
                    buttonText="Detallar Bautizo"
                />

                <x-category-card 
                    color="pink" 
                    icon="music" 
                    title="Solo Fiestas" 
                    description="Eventos corporativos, aniversarios y noches de baile."
                    buttonText="Lanzar Fiesta"
                />
            </div>
        </div>
    </section>

    <section class="upcoming-events">
        <div class="container">
            <h2 class="section-title">Próximos Próximos | Próximos Próximos</h2>
            <div class="events-carousel">
                <button class="carousel-nav prev">
                    <i data-lucide="chevron-left"></i>
                </button>
                
                <div class="events-grid">
                    <x-event-card 
                        image="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=400&q=80"
                        title="15 Años de Sofía"
                        date="06 May 2023"
                    />

                    <x-event-card 
                        image="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=400&q=80"
                        title="Boda Ana & Luis"
                        date="27 May 2023"
                    />

                    <x-event-card 
                        image="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=400&q=80"
                        title="Boda Ana & Luis"
                        date="29 May 2023"
                    />

                    <x-event-card 
                        image="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=400&q=80"
                        title="15 Años de Sofía"
                        date="26 May 2023"
                    />
                </div>

                <button class="carousel-nav next">
                    <i data-lucide="chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
@endsection
