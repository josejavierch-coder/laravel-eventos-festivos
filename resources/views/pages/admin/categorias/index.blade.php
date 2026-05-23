@extends('layouts.admin')

@section('title', 'Gestión de Categorías - EventosFestivos')
@section('header_title', 'Categorías')

@section('styles')
<style>
    .search-container {
        display: flex;
        gap: 10px;
        margin-bottom: 1.5rem;
        align-items: center;
    }
    .search-input {
        flex: 1;
        padding: 10px 15px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: white;
    }
    .btn-report {
        background: #b71c1c; /* Anaranjado oscuro rojizo / Rojo oscuro */
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
    /* Pagination tabs style */
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
</style>
@endsection

@section('content')
    <div class="chart-card span-2" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>Lista de Categorías</h2>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('categorias.pdf', ['search' => request('search')]) }}" class="btn-report">
                    <i data-lucide="file-text"></i> Reporte PDF
                </a>
                <button onclick="openModal('create')" class="btn btn-gradient">
                    <i data-lucide="plus"></i> Nueva Categoría
                </button>
            </div>
        </div>

        <form action="{{ route('categorias.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o descripción..." class="search-input">
            <button type="submit" class="btn btn-gradient" style="padding: 10px 20px;">
                <i data-lucide="search"></i> Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('categorias.index') }}" class="btn btn-outline" style="padding: 10px 20px; text-decoration: none;">Limpiar</a>
            @endif
        </form>

        <table class="event-table" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: #888; font-size: 0.9rem;">
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Eventos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr style="background: rgba(255,255,255,0.02); opacity: {{ $categoria->trashed() ? '0.5' : '1' }};">
                        <td style="padding: 15px;">
                            <strong>{{ $categoria->nombre }}</strong>
                        </td>
                        <td><code>{{ $categoria->slug }}</code></td>
                        <td>{{ $categoria->eventos_festivos_count }}</td>
                        <td>
                            @if($categoria->trashed())
                                <span class="status-tag" style="background: rgba(255, 138, 101, 0.2); color: #ff8a65;">
                                    Eliminado
                                </span>
                            @else
                                <form action="{{ route('categorias.toggle-status', $categoria) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <label class="switch">
                                        <input type="checkbox" {{ $categoria->estado ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span class="slider"></span>
                                    </label>
                                </form>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                @if(!$categoria->trashed())
                                    <button onclick="openModal('edit', {{ json_encode($categoria) }})" style="background:none; border:none; color: var(--primary-teal); cursor:pointer;">
                                        <i data-lucide="edit-2" size="18"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ route('categorias.destroy', $categoria) }}')" style="background: none; border: none; color: #ff8a65; cursor: pointer; padding: 0;">
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
            {{ $categorias->links() }}
        </div>
    </div>

    <!-- Modal para Crear/Editar -->
    <div id="categoriaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle">Nueva Categoría</h2>
            </div>
            
            <div class="modal-body">
                <form id="categoriaForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div style="margin-bottom: 1.5rem;">
                        <label>Nombre de la Categoría</label>
                        <input type="text" name="nombre" id="cat_nombre" required>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Descripción</label>
                        <textarea name="descripcion" id="cat_descripcion" rows="3"></textarea>
                    </div>

                    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="estado" value="1" id="cat_estado" style="width: auto !important;">
                        <label for="cat_estado" style="margin-bottom: 0;">Categoría Activa</label>
                    </div>

                    <button type="submit" class="btn-modal-save">
                        <i data-lucide="save"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('categoriaModal');
    const form = document.getElementById('categoriaForm');
    const methodInput = document.getElementById('formMethod');
    const title = document.getElementById('modalTitle');

    function openModal(mode, data = null) {
        if (mode === 'edit') {
            title.innerText = 'Editar Categoría';
            form.action = `{{ url('admin/categorias') }}/${data.id}`;
            methodInput.value = 'PUT';
            document.getElementById('cat_nombre').value = data.nombre;
            document.getElementById('cat_descripcion').value = data.descripcion || '';
            document.getElementById('cat_estado').checked = data.estado;
        } else {
            title.innerText = 'Nueva Categoría';
            form.action = `{{ route('categorias.store') }}`;
            methodInput.value = 'POST';
            form.reset();
            document.getElementById('cat_estado').checked = true;
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
            text: "Se realizará un eliminado lógico de esta categoría.",
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

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            background: '#222',
            color: '#fff',
            confirmButtonColor: '#26ba9d'
        });
    @endif
</script>
@endsection
