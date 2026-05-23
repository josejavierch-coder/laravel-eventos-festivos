@extends('layouts.admin')

@section('title', 'Mi Perfil - EventosFestivos')
@section('header_title', 'Mi Cuenta')

@section('content')
    <div class="chart-card span-2" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h2>Modificar mis datos personales</h2>
            <p style="color: #888;">Actualiza tu información de contacto y contraseña.</p>
        </div>

        <form action="{{ route('admin.perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       required>
                @error('name') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       required>
                @error('email') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Contraseña Actual (solo si deseas cambiarla)</label>
                <input type="password" name="current_password" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                @error('current_password') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Nueva Contraseña</label>
                <input type="password" name="password" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                @error('password') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
            </div>

            <button type="submit" class="btn btn-gradient" style="width: 100%;">
                <i data-lucide="save"></i> Guardar Cambios
            </button>
        </form>
    </div>
@endsection
