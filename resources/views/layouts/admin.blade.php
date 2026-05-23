<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control - EventosFestivos')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <style>
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 2500; backdrop-filter: blur(4px);
        }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 992px) { #mobileMenuToggle { display: flex !important; } }

        .modal {
            display: none; position: fixed; z-index: 4000; left: 0; top: 0; width: 100%; height: 100%;
            overflow: auto; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);
        }
        .modal-content {
            background-color: #1e293b; 
            margin: 5% auto; 
            padding: 0; /* Remove padding to handle header/body separately if needed, or keep it consistent */
            border: 1px solid rgba(255,255,255,0.1);
            width: 95%; 
            max-width: 600px; 
            border-radius: 24px; 
            color: white;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
        }
        .modal-header {
            padding: 30px 40px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }
        .modal-header h2 {
            color: var(--color-blue); /* Professional Blue Title */
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .modal-body {
            padding: 30px 40px 40px;
        }
        .close-modal {
            position: absolute;
            right: 25px;
            top: 25px;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .close-modal:hover {
            background: #ef4444;
            color: white;
            transform: rotate(90deg);
        }
        .modal-content label { color: #94a3b8 !important; font-weight: 600; margin-bottom: 8px; display: block; font-size: 0.9rem; }
        .modal-content input, .modal-content textarea, .modal-content select {
            background: rgba(15, 23, 42, 0.5) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
            padding: 14px 16px !important;
            border-radius: 12px !important;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .modal-content input:focus {
            border-color: var(--color-blue) !important;
            background: rgba(15, 23, 42, 0.8) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            outline: none;
        }
        .btn-modal-save {
            background: var(--color-blue);
            color: white !important;
            width: 100%;
            padding: 16px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }
        .btn-modal-save:hover {
            background: var(--color-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
        }

        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .toast { 
            min-width: 300px; padding: 16px 20px; border-radius: 12px; color: white; font-weight: 600; 
            display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
            animation: slideIn 0.3s ease forwards; 
        }
        @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }

        /* Switch Toggle Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255,255,255,0.1);
            transition: .4s;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 3px;
            background-color: #94a3b8;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: rgba(38, 186, 157, 0.2);
            border-color: rgba(38, 186, 157, 0.3);
        }
        input:checked + .slider:before {
            transform: translateX(26px);
            background-color: #26ba9d;
        }
    </style>
    @yield('styles')
</head>
<body class="admin-body">
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleMobileMenu()"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="mainSidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px;">
                <span class="logo-icon">E</span>
                <span class="logo-text">EventosFestivos</span>
            </a>
        </div>
        
        <div style="padding: 0 20px 20px;">
            <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 12px; border: 1px solid var(--border-light);">
                <p style="color: #475569; font-size: 0.7rem; text-transform: uppercase; font-weight: 800; margin-bottom: 5px;">Sistema</p>
                <p style="color: white; font-size: 0.95rem; font-weight: 700;">Administración</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i data-lucide="layout-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ route('categorias.index') }}" class="{{ request()->routeIs('categorias.*') ? 'active' : '' }}"><i data-lucide="layers"></i> Categorías</a></li>
                <li><a href="{{ route('salones.index') }}" class="{{ request()->routeIs('salones.*') ? 'active' : '' }}"><i data-lucide="map-pin"></i> Salones</a></li>
                <li><a href="{{ route('admin.eventos.index') }}" class="{{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}"><i data-lucide="party-popper"></i> Eventos</a></li>
                <li><a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}"><i data-lucide="users"></i> Usuarios</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <header class="dashboard-header">
            <button id="mobileMenuToggle" onclick="toggleMobileMenu()" style="display: none; background: none; border: 1px solid var(--border-light); color: white; padding: 8px; border-radius: 8px; margin-right: 15px; cursor: pointer;">
                <i data-lucide="menu"></i>
            </button>
            <h1 style="flex: 1;">@yield('header_title', 'Panel de Control')</h1>
            
            <div class="header-user-actions">
                <div class="user-profile-dropdown" id="userProfileDropdown" style="position: relative;">
                    <div id="userMenuTrigger" style="display: flex; align-items: center; gap: 12px; cursor: pointer; background: rgba(255,255,255,0.05); padding: 8px 18px; border-radius: 40px; border: 1px solid var(--border-light);">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" alt="User" style="width: 32px; height: 32px; border-radius: 50%;">
                        <span style="color: white; font-weight: 700; font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                        <i data-lucide="chevron-down" size="16" style="color: var(--text-muted);"></i>
                    </div>
                    
                    <div id="userDropdown">
                        <div class="dropdown-header">
                            <p>{{ auth()->user()->name }}</p>
                            <small>Administrador</small>
                        </div>
                        <div class="dropdown-body">
                            <button onclick="openProfileModal()" class="dropdown-item">
                                <i data-lucide="user" size="18"></i> Mi Perfil
                            </button>
                            <button onclick="openPasswordModal()" class="dropdown-item">
                                <i data-lucide="key" size="18"></i> Cambiar Contraseña
                            </button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item logout">
                                    <i data-lucide="log-out" size="18"></i> Salir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="toast-container">
            @if(session('success'))
                <div class="toast" style="background: var(--color-teal);">
                    <i data-lucide="check-circle" size="20"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="toast" style="background: #ef4444;">
                        <i data-lucide="alert-circle" size="20"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <!-- Modals -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closeProfileModal()">&times;</span>
                <h2>Mis Datos</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.perfil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1.5rem;">
                        <label>Nombre</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div style="margin-bottom: 2rem;">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <button type="submit" class="btn-modal-save">Actualizar Datos</button>
                </form>
            </div>
        </div>
    </div>

    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closePasswordModal()">&times;</span>
                <h2>Seguridad: Cambiar Contraseña</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.perfil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1.5rem;">
                        <label>Contraseña Actual</label>
                        <input type="password" name="current_password" required placeholder="••••••••">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label>Nueva Contraseña</label>
                        <input type="password" name="password" required placeholder="Mínimo 8 caracteres">
                    </div>
                    <div style="margin-bottom: 2rem;">
                        <label>Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" required placeholder="Repite la nueva contraseña">
                    </div>
                    <button type="submit" class="btn-modal-save">Actualizar Contraseña</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleMobileMenu() {
            document.getElementById('mainSidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        const trigger = document.getElementById('userMenuTrigger');
        const dropdown = document.getElementById('userDropdown');
        
        if(trigger) {
            trigger.onclick = function(e) {
                e.stopPropagation();
                const isVisible = dropdown.style.display === 'block';
                dropdown.style.display = isVisible ? 'none' : 'block';
            };
        }

        function openProfileModal() {
            document.getElementById('profileModal').style.display = 'block';
            if(dropdown) dropdown.style.display = 'none';
        }
        function closeProfileModal() {
            document.getElementById('profileModal').style.display = 'none';
        }

        function openPasswordModal() {
            document.getElementById('passwordModal').style.display = 'block';
            if(dropdown) dropdown.style.display = 'none';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }

        window.onclick = function(event) {
            // Close modals on outside click
            const profileModal = document.getElementById('profileModal');
            const passwordModal = document.getElementById('passwordModal');
            const userModal = document.getElementById('userModal');
            const categoryModal = document.getElementById('categoriaModal');
            const eventModal = document.getElementById('eventoModal');
            const salonModal = document.getElementById('salonModal');

            if (event.target == profileModal) closeProfileModal();
            if (event.target == passwordModal) closePasswordModal();
            if (event.target == userModal && typeof closeUserModal === 'function') closeUserModal();
            if (event.target == categoryModal && typeof closeModal === 'function') closeModal();
            if (event.target == eventModal && typeof closeEventoModal === 'function') closeEventoModal();
            if (event.target == salonModal && typeof closeSalonModal === 'function') closeSalonModal();
            
            // Close user dropdown on outside click
            const userProfileDropdown = document.getElementById('userProfileDropdown');
            if (dropdown && userProfileDropdown && !userProfileDropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }

            // Close any other potential dropdowns using .menu-trigger or .card-dropdown
            if (!event.target.closest('.user-profile-dropdown')) {
                const dropdowns = document.querySelectorAll('#userDropdown, .card-dropdown');
                dropdowns.forEach(d => {
                    if (d.style.display === 'block' && !d.contains(event.target)) {
                        d.style.display = 'none';
                    }
                });
            }

            const sidebar = document.getElementById('mainSidebar');
            if (sidebar && sidebar.classList.contains('active') && event.target.id === 'sidebarOverlay') {
                toggleMobileMenu();
            }
        };

        // Auto-hide toasts
        document.querySelectorAll('.toast').forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>
</html>