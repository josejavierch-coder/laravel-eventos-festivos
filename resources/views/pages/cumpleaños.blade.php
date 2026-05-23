@extends('layouts.dashboard')

@section('title', 'Gestión de Cumpleaños - EventosFestivos')
@section('page-title', 'Gestión de Cumpleaños')

@section('content')
    <div class="management-header">
        <h2 style="font-size: 1.8rem; font-weight: 700;">Cumpleaños</h2>
        <div class="total-badge">Total Cumpleaños: 184</div>
    </div>

    <div class="action-bar">
        <div class="search-container">
            <i data-lucide="search"></i>
            <input type="text" placeholder="Buscar cumpleaños por nombre, fecha o temática...">
        </div>
        <button class="btn btn-secondary">
            <i data-lucide="printer"></i>
            Imprimir Listado
        </button>
        <button class="btn btn-success" title="Nuevo Evento">
            <i data-lucide="plus"></i>
            Registrar Nuevo Cumpleaños
        </button>
    </div>

    <div class="cards-grid">
        <x-birthday-card 
            name="Sofía Gómez" 
            date="15 Jul 2026" 
            location="Salón Sol" 
            theme="Glamour" 
            status="active" 
            statusLabel="Active" 
        />

        <x-birthday-card 
            name="Mateo Torres" 
            date="02 Aug Mayo, 2026" 
            location="Jardín Estrella" 
            theme="Superhéroes" 
            status="pending" 
            statusLabel="Pending" 
        />

        <x-birthday-card 
            name="Laura Díaz" 
            date="22 Oct Mayo, 2026" 
            location="Salón Cometas" 
            theme="Princesas" 
            status="active" 
            statusLabel="Active" 
        />

        <x-birthday-card 
            name="Juan Pérez" 
            date="25 de Mayo, 2026" 
            location="Salón Luna" 
            theme="Glamour" 
            status="active" 
            statusLabel="" 
        />

        <x-birthday-card 
            name="Evento Pendiente" 
            date="25 de Mayo, 2026" 
            location="Salón Luna" 
            theme="Conta" 
            status="pending" 
            statusLabel="Pending" 
            style="margin-top: 50px;"
        />

        <x-birthday-card 
            name="Camúmtos" 
            date="25 de Mayo, 2026" 
            location="Salón Luna" 
            theme="Princesas" 
            status="active" 
            statusLabel="" 
        />
    </div>
@endsection
