@extends('layouts.admin')

@section('title', (isset($categoria) ? 'Editar' : 'Nueva') . ' Categoría - EventosFestivos')
@section('header_title', isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría')

@section('content')
    <div class="chart-card span-2" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2>{{ isset($categoria) ? 'Modificar datos de ' . $categoria->nombre : 'Completar los siguientes datos' }}</h2>
            <a href="{{ route('categorias.index') }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">
                <i data-lucide="arrow-left" size="16"></i> Volver al listado
            </a>
        </div>

        <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
            @csrf
            @if(isset($categoria)) @method('PUT') @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Nombre de la Categoría</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" 
                       required>
                @error('nombre') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Slug (Opcional - se genera solo)</label>
                <input type="text" name="slug" value="{{ old('slug', $categoria->slug ?? '') }}" 
                       style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #888;" 
                       placeholder="nombre-de-la-categoria">
                @error('slug') <span style="color: #ff8a65; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ccc; margin-bottom: 0.5rem;">Descripción</label>
                <textarea name="descripcion" rows="4" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
            </div>

            <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="estado" value="1" id="estado" {{ old('estado', $categoria->estado ?? true) ? 'checked' : '' }}>
                <label for="estado" style="color: #ccc;">Categoría Activa</label>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn btn-gradient" style="flex: 1;">
                    <i data-lucide="save"></i> {{ isset($categoria) ? 'Actualizar Categoría' : 'Guardar Categoría' }}
                </button>
                <a href="{{ route('categorias.index') }}" class="btn btn-outline" style="text-decoration: none; text-align: center;">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
