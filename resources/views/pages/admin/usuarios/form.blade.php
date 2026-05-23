@extends('layouts.admin')

@section('title', (isset($usuario) ? 'Editar' : 'Nuevo') . ' Usuario - EventosFestivos')
@section('header_title', isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario')

@section('content')
    <div class="chart-card span-2" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2>{{ isset($usuario) ? 'Modificar datos de ' . $usuario->name : 'Completar los siguientes datos' }}</h2>
            <a href="{{ route('usuarios.index') }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">
                <i data-lucide="arrow-left" size="16"></i> Volver al listado
            </a>
        </div>

        <form action="{{ isset($usuario) ? route('usuarios.update', $usuario) : route('usuarios.store') }}" method="POST">
            @csrf
            @if(isset($usuario)) @method('PUT') @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       required>
                @error('name') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       required>
                @error('email') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Contraseña {{ isset($usuario) ? '(dejar en blanco para no cambiar)' : '' }}</label>
                <input type="password" name="password" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       {{ isset($usuario) ? '' : 'required' }}>
                @error('password') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       {{ isset($usuario) ? '' : 'required' }}>
            </div>

            <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_admin" value="1" id="is_admin" {{ old('is_admin', $usuario->is_admin ?? false) ? 'checked' : '' }}>
                <label for="is_admin" style="color: #ccc;">Es Administrador</label>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn btn-gradient" style="flex: 1;">
                    <i data-lucide="save"></i> {{ isset($usuario) ? 'Actualizar Usuario' : 'Guardar Usuario' }}
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline" style="text-decoration: none; text-align: center;">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
