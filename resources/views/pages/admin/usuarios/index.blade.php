@extends('layouts.admin')

@section('title', 'Gestión de Usuarios - EventosFestivos')
@section('header_title', 'Usuarios')

@section('content')
    <div class="chart-card span-2" style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>Lista de Usuarios</h2>
            <button onclick="openUserModal('create')" class="btn btn-gradient">
                <i data-lucide="user-plus"></i> Nuevo Usuario
            </button>
        </div>

        <table class="event-table" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: #888; font-size: 0.9rem;">
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                    <tr style="background: rgba(255,255,255,0.02);">
                        <td style="padding: 15px;">
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="status-tag" style="background: {{ $user->is_admin ? 'rgba(38, 186, 157, 0.2)' : 'rgba(255, 255, 255, 0.1)' }}; color: {{ $user->is_admin ? '#26ba9d' : '#ccc' }};">
                                {{ $user->is_admin ? 'Administrador' : 'Usuario' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <button onclick="openUserModal('edit', {{ json_encode($user) }})" style="background:none; border:none; color: var(--primary-teal); cursor:pointer;">
                                    <i data-lucide="edit-2" size="18"></i>
                                </button>
                                <button onclick="confirmDeleteUser('{{ route('usuarios.destroy', $user) }}')" style="background: none; border: none; color: #ff8a65; cursor: pointer; padding: 0;">
                                    <i data-lucide="trash-2" size="18"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $usuarios->links() }}
        </div>
    </div>

    <!-- Modal para Usuarios -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closeUserModal()">&times;</span>
                <h2 id="userModalTitle">Nuevo Usuario</h2>
            </div>
            
            <div class="modal-body">
                <form id="userForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="userFormMethod" value="POST">

                    <div style="margin-bottom: 1.5rem;">
                        <label>Nombre Completo</label>
                        <input type="text" name="name" id="user_name" required>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Correo Electrónico</label>
                        <input type="email" name="email" id="user_email" required>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Contraseña <span id="pwdHint" style="font-size: 0.7rem; color: #888;"></span></label>
                        <input type="password" name="password" id="user_password">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label>Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="user_password_confirmation">
                    </div>

                    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="is_admin" value="1" id="user_is_admin" style="width: auto !important;">
                        <label for="user_is_admin" style="margin-bottom:0;">Es Administrador</label>
                    </div>

                    <button type="submit" class="btn-modal-save">
                        <i data-lucide="save"></i> Guardar Usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userMethod = document.getElementById('userFormMethod');
    const userTitle = document.getElementById('userModalTitle');

    function openUserModal(mode, data = null) {
        if (mode === 'edit') {
            userTitle.innerText = 'Editar Usuario';
            userForm.action = `{{ url('admin/usuarios') }}/${data.id}`;
            userMethod.value = 'PUT';
            document.getElementById('user_name').value = data.name;
            document.getElementById('user_email').value = data.email;
            document.getElementById('user_is_admin').checked = data.is_admin;
            document.getElementById('user_password').required = false;
            document.getElementById('user_password_confirmation').required = false;
            document.getElementById('pwdHint').innerText = '(dejar en blanco para no cambiar)';
        } else {
            userTitle.innerText = 'Nuevo Usuario';
            userForm.action = `{{ route('usuarios.store') }}`;
            userMethod.value = 'POST';
            userForm.reset();
            document.getElementById('user_password').required = true;
            document.getElementById('user_password_confirmation').required = true;
            document.getElementById('pwdHint').innerText = '';
        }
        userModal.style.display = 'block';
        lucide.createIcons();
    }

    function closeUserModal() {
        userModal.style.display = 'none';
    }

    function confirmDeleteUser(url) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El usuario será eliminado permanentemente.",
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

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            background: '#222',
            color: '#fff',
            confirmButtonColor: '#ff8a65'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: "Hubo errores en el formulario. Por favor revisa los datos.",
            background: '#222',
            color: '#fff',
            confirmButtonColor: '#ff8a65'
        });
    @endif
</script>
@endsection
