@extends('layouts.admin')

@section('title', 'Gestión de Salones - EventosFestivos')
@section('header_title', 'Salones de Eventos')

@section('styles')
<style>
    .search-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 1.5rem;
        align-items: center;
    }
    .search-input {
        flex: 1;
        min-width: 200px;
        padding: 10px 15px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: white;
    }
    .btn-report {
        background: #b71c1c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        text-decoration: none;
    }
    .btn-report:hover {
        background: #d32f2f;
    }
    .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
    }
    .pagination-container .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
    }
    .pagination-container .page-item .page-link {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #888;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .pagination-container .page-item.active .page-link {
        background: var(--primary-teal);
        color: white;
        border-color: var(--primary-teal);
    }
    .pagination-container .page-item .page-link:hover:not(.active) {
        background: rgba(255,255,255,0.1);
        color: white;
    }
    /* Modal de previsualización de imagen */
    .img-preview-modal {
        display: none;
        position: fixed;
        z-index: 3000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    .img-preview-modal.active {
        opacity: 1;
        pointer-events: auto;
        display: flex;
    }
    .img-preview-content {
        max-width: 90%;
        max-height: 90%;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    .close-preview {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
    <div class="chart-card span-2" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
            <h2>Lista de Salones / Locales</h2>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('salones.pdf', ['search' => request('search')]) }}" class="btn-report">
                    <i data-lucide="file-text"></i> Reporte PDF
                </a>
                <button onclick="openModal('create')" class="btn btn-gradient">
                    <i data-lucide="plus"></i> Nuevo Salón
                </button>
            </div>
        </div>

        <form action="{{ route('salones.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o dirección..." class="search-input">
            <button type="submit" class="btn btn-gradient" style="padding: 10px 20px;">
                <i data-lucide="search"></i> Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('salones.index') }}" class="btn btn-outline" style="padding: 10px 20px; text-decoration: none;">Limpiar</a>
            @endif
        </form>

        <table class="event-table" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: #888; font-size: 0.9rem;">
                    <th>Salón</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salones as $salon)
                    <tr style="background: rgba(255,255,255,0.02); opacity: {{ $salon->trashed() ? '0.5' : '1' }};">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ $salon->imagen ? asset('storage/' . $salon->imagen) : 'https://via.placeholder.com/50' }}" 
                                     style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; cursor: pointer;"
                                     onclick="previewImage(this.src)">
                                <strong>{{ $salon->nombre }}</strong>
                            </div>
                        </td>
                        <td>{{ $salon->direccion }}</td>
                        <td>
                            @if($salon->trashed())
                                <span class="status-tag" style="background: rgba(255, 138, 101, 0.2); color: #ff8a65;">
                                    Eliminado
                                </span>
                            @else
                                <form action="{{ route('salones.toggle-status', $salon) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <label class="switch">
                                        <input type="checkbox" {{ $salon->estado ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span class="slider"></span>
                                    </label>
                                </form>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                @if(!$salon->trashed())
                                    <button onclick="openModal('edit', {{ json_encode($salon) }})" style="background:none; border:none; color: var(--primary-teal); cursor:pointer;">
                                        <i data-lucide="edit-2" size="18"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ route('salones.destroy', $salon) }}')" style="background: none; border: none; color: #ff8a65; cursor: pointer; padding: 0;">
                                        <i data-lucide="trash-2" size="18"></i>
                                    </button>
                                @else
                                    <span style="color: #666; font-size: 0.8rem;">Sin acciones</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $salones->links() }}
        </div>
    </div>

    <!-- Modal para Salones -->
    <div id="salonModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle">Nuevo Salón</h2>
            </div>
            
            <div class="modal-body">
                <form id="salonForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div style="margin-bottom: 1.5rem;">
                        <label>Nombre del Salón</label>
                        <input type="text" name="nombre" id="sal_nombre" required>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Dirección</label>
                        <input type="text" name="direccion" id="sal_direccion" required>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Imagen del Salón</label>
                        <input type="file" name="imagen" style="width: 100%; color: #888; background:none !important; border:none !important; padding:0 !important;">
                    </div>

                    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="estado" value="1" id="sal_estado" style="width: auto !important;">
                        <label for="sal_estado" style="margin-bottom: 0;">Salón Activo</label>
                    </div>

                    <button type="submit" class="btn-modal-save">
                        <i data-lucide="save"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Previsualización de Imagen -->
    <div id="imagePreviewModal" class="img-preview-modal" onclick="this.classList.remove('active')">
        <span class="close-preview" onclick="this.parentElement.classList.remove('active')">&times;</span>
        <img id="previewImg" class="img-preview-content">
    </div>
@endsection

@section('scripts')
<script>
    function previewImage(src) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('previewImg');
        img.src = src;
        modal.classList.add('active');
    }

    const modal = document.getElementById('salonModal');
    const form = document.getElementById('salonForm');
    const methodInput = document.getElementById('formMethod');
    const title = document.getElementById('modalTitle');

    function openModal(mode, data = null) {
        if (mode === 'edit') {
            title.innerText = 'Editar Salón';
            form.action = `{{ url('admin/salones') }}/${data.id}`;
            methodInput.value = 'PUT';
            document.getElementById('sal_nombre').value = data.nombre;
            document.getElementById('sal_direccion').value = data.direccion;
            document.getElementById('sal_estado').checked = data.estado;
        } else {
            title.innerText = 'Nuevo Salón';
            form.action = `{{ route('salones.store') }}`;
            methodInput.value = 'POST';
            form.reset();
            document.getElementById('sal_estado').checked = true;
        }
        modal.style.display = 'block';
        lucide.createIcons();
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    function confirmDelete(url) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se realizará un eliminado lógico de este salón.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26ba9d',
            cancelButtonColor: '#ff8a65',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#222',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                const f = document.createElement('form');
                f.action = url;
                f.method = 'POST';
                f.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(f);
                f.submit();
            }
        })
    }
</script>
@endsection
