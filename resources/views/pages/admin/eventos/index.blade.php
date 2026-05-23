@extends('layouts.admin')

@section('title', 'Gestión de Eventos - EventosFestivos')
@section('header_title', 'Eventos Festivos')

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

    /* Estilos para que los combos se vean bien en el modal oscuro */
    #eventoModal select option {
        background-color: #1a2233 !important;
        color: white !important;
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>Lista de Eventos</h2>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.eventos.pdf', ['search' => request('search')]) }}" class="btn-report">
                    <i data-lucide="file-text"></i> Reporte PDF
                </a>
                <button onclick="openEventoModal('create')" class="btn btn-gradient">
                    <i data-lucide="plus"></i> Nuevo Evento
                </button>
            </div>
        </div>

        <form action="{{ route('admin.eventos.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título, categoría o salón..." class="search-input">
            <button type="submit" class="btn btn-gradient" style="padding: 10px 20px;">
                <i data-lucide="search"></i> Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline" style="padding: 10px 20px; text-decoration: none;">Limpiar</a>
            @endif
        </form>

        @if(session('error'))
            <div style="background: rgba(229, 62, 62, 0.1); border-left: 4px solid #e53e3e; color: #ff8a65; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif

        <table class="event-table" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: #888; font-size: 0.9rem;">
                    <th>Evento</th>
                    <th>Categoría</th>
                    <th>Salón / Local</th>
                    <th>Fecha Evento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $evento)
                    <tr style="background: rgba(255,255,255,0.02);">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ $evento->imagen_representativa ? asset('storage/' . $evento->imagen_representativa) : 'https://via.placeholder.com/50' }}" 
                                     style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; cursor: pointer;"
                                     onclick="previewImage(this.src)">
                                <div>
                                    <strong>{{ Str::limit($evento->titulo, 40) }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>{{ $evento->categoria->nombre ?? 'N/A' }}</td>
                        <td>{{ $evento->salon->nombre ?? 'N/A' }}</td>
                        <td>{{ $evento->fecha_evento ? $evento->fecha_evento->format('d/m/Y') : 'Sin fecha' }}</td>
                        <td>
                            <form action="{{ route('admin.eventos.toggle-status', $evento) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <label class="switch">
                                    <input type="checkbox" {{ $evento->estado ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="slider"></span>
                                </label>
                            </form>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <button onclick="openEventoModal('edit', {{ json_encode($evento) }})" style="background:none; border:none; color: var(--primary-teal); cursor:pointer; padding:0;">
                                    <i data-lucide="edit-2" size="18"></i>
                                </button>
                                @if($evento->fecha_evento > now())
                                    <button onclick="confirmDeleteEvento('{{ route('admin.eventos.destroy', $evento) }}')" style="background: none; border: none; color: #ff8a65; cursor: pointer; padding: 0;">
                                        <i data-lucide="trash-2" size="18"></i>
                                    </button>
                                @else
                                    <span title="Consolidado (No se puede eliminar)" style="color: #666; cursor: help;">
                                        <i data-lucide="lock" size="18"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $eventos->links() }}
        </div>
    </div>

    <!-- Modal para Eventos -->
    <div id="eventoModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <span class="close-modal" onclick="closeEventoModal()">&times;</span>
                <h2 id="eventoModalTitle">Nuevo Evento</h2>
            </div>
            
            <div class="modal-body">
                <form id="eventoForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="eventoFormMethod" value="POST">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                        <div>
                            <div style="margin-bottom: 1.2rem;">
                                <label>Título del Evento</label>
                                <input type="text" name="titulo" id="ev_titulo" required>
                            </div>

                            <div style="margin-bottom: 1.2rem;">
                                <label>Categoría</label>
                                <select name="categoria_id" id="ev_categoria" required>
                                    <option value="">Seleccione Categoría</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="margin-bottom: 1.2rem;">
                                <label>Salón / Local</label>
                                <select name="salon_id" id="ev_salon" required>
                                    <option value="">Seleccione Local</option>
                                    @foreach($salones as $sal)
                                        <option value="{{ $sal->id }}">{{ $sal->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <div style="margin-bottom: 1.2rem;">
                                <label>Imagen Representativa</label>
                                <input type="file" name="imagen_representativa" style="background:none !important; border:none !important; padding:0 !important; color:#888;">
                            </div>

                            <div style="margin-bottom: 1.2rem;">
                                <label>Fecha del Evento</label>
                                <input type="date" name="fecha_evento" id="ev_fecha_evento" required>
                            </div>

                            <div style="margin-bottom: 1.2rem;">
                                <label>Fotos de la Galería (Máx. 5 en total)</label>
                                <div id="current_photos" style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;"></div>
                                <input type="file" name="fotos[]" id="ev_fotos" multiple style="background:none !important; border:none !important; padding:0 !important; color:#888;">
                                <small id="fotos_help" style="color: #64748b; font-size: 0.75rem; display: block; margin-top: 5px;">
                                    Puedes seleccionar varias fotos a la vez (Ctrl+Clic). Total permitido: 5 fotos.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem; margin-top: 10px;">
                        <label>Descripción</label>
                        <textarea name="descripcion" id="ev_descripcion" rows="3"></textarea>
                    </div>

                    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="estado" value="1" id="ev_estado" style="width: auto !important;">
                        <label for="ev_estado" style="margin-bottom:0;">Evento Activo</label>
                    </div>

                    <button type="submit" class="btn-modal-save">
                        <i data-lucide="save"></i> Guardar Evento
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

    const evModal = document.getElementById('eventoModal');
    const evForm = document.getElementById('eventoForm');
    const evMethod = document.getElementById('eventoFormMethod');
    const evTitle = document.getElementById('eventoModalTitle');

    function openEventoModal(mode, data = null) {
        const currentPhotosContainer = document.getElementById('current_photos');
        currentPhotosContainer.innerHTML = '';
        
        if (mode === 'edit') {
            evTitle.innerText = 'Editar Evento';
            evForm.action = `{{ url('admin/eventos') }}/${data.id}`;
            evMethod.value = 'PUT';
            document.getElementById('ev_titulo').value = data.titulo;
            document.getElementById('ev_categoria').value = data.categoria_id || '';
            document.getElementById('ev_salon').value = data.salon_id || '';
            document.getElementById('ev_descripcion').value = data.descripcion || '';
            document.getElementById('ev_estado').checked = data.estado;
            if (data.fecha_evento) {
                document.getElementById('ev_fecha_evento').value = data.fecha_evento.split('T')[0];
            }

            // Show current photos
            if (data.fotos && data.fotos.length > 0) {
                data.fotos.forEach(foto => {
                    const div = document.createElement('div');
                    div.style.position = 'relative';
                    div.style.width = '60px';
                    div.style.height = '60px';
                    
                    const img = document.createElement('img');
                    img.src = `{{ asset('storage') }}/${foto.ruta}`;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '4px';
                    
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '&times;';
                    btn.style.position = 'absolute';
                    btn.style.top = '-5px';
                    btn.style.right = '-5px';
                    btn.style.background = '#ff8a65';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    btn.style.borderRadius = '50%';
                    btn.style.width = '20px';
                    btn.style.height = '20px';
                    btn.style.cursor = 'pointer';
                    btn.style.fontSize = '14px';
                    btn.style.lineHeight = '18px';
                    btn.onclick = () => confirmDeletePhoto(foto.id);
                    
                    div.appendChild(img);
                    div.appendChild(btn);
                    currentPhotosContainer.appendChild(div);
                });
            }
        } else {
            evTitle.innerText = 'Nuevo Evento';
            evForm.action = `{{ route('admin.eventos.store') }}`;
            evMethod.value = 'POST';
            evForm.reset();
            document.getElementById('ev_estado').checked = true;
        }
        evModal.style.display = 'block';
        lucide.createIcons();
    }

    function confirmDeletePhoto(fotoId) {
        Swal.fire({
            title: '¿Eliminar foto?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8a65',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#222',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                const f = document.createElement('form');
                f.action = `{{ url('admin/eventos/foto') }}/${fotoId}`;
                f.method = 'POST';
                f.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(f);
                f.submit();
            }
        });
    }

    function closeEventoModal() {
        eventoModal.style.display = 'none';
    }

    function confirmDeleteEvento(url) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El evento será eliminado definitivamente.",
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

    // Listener para mostrar feedback de archivos seleccionados
    document.getElementById('ev_fotos').addEventListener('change', function() {
        const fileList = Array.from(this.files);
        const fotosHelp = document.getElementById('fotos_help');
        if (fileList.length > 0) {
            fotosHelp.innerHTML = `<strong>Seleccionados (${fileList.length}):</strong> ${fileList.map(f => f.name).join(', ')}`;
            fotosHelp.style.color = '#26ba9d';
            
            if (fileList.length > 5) {
                fotosHelp.innerHTML = `<strong>Error:</strong> Máximo 5 fotos permitidas. Has seleccionado ${fileList.length}.`;
                fotosHelp.style.color = '#ff8a65';
                this.value = ''; // Limpiar selección
            }
        } else {
            fotosHelp.innerText = 'Puedes seleccionar varias fotos a la vez (Ctrl+Clic). Total permitido: 5 fotos.';
            fotosHelp.style.color = '#64748b';
        }
    });
</script>
@endsection
