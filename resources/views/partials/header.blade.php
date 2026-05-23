<header class="main-header">
    <div class="container header-content">
        <div class="logo">
            <span class="logo-icon">E</span>
            <span class="logo-text">EventosFestivos</span>
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
                <li><a href="#">Cómo Funciona</a></li>
                <li><a href="#" class="">Categorías</a></li>
                <li><a href="#">Precios</a></li>
                <li><a href="#">Soporte</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <button class="btn btn-outline">Acceso Clientes</button>
            <a href="{{ route('login') }}" class="btn btn-gradient">
                <i data-lucide="lock"></i>
                Panel de Administración
                <i data-lucide="lock"></i>
            </a>
        </div>
    </div>
</header>
