<aside class="sidebar">
    <div class="sidebar-logo">
        <span class="logo-icon" style="background: white; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">E</span>
        <span class="logo-text">EventosFestivos</span>
    </div>
    
    <button class="sidebar-admin-btn">
        <i data-lucide="lock"></i>
        Administración
    </button>

    <nav class="sidebar-nav">
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i data-lucide="layout-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('cumpleaños') }}" class="{{ request()->routeIs('cumpleaños') ? 'active' : '' }}"><i data-lucide="party-popper"></i> Cumpleaños</a></li>
            <li><a href="#"><i data-lucide="heart"></i> Matrimonios</a></li>
            <li><a href="#"><i data-lucide="waves"></i> Bautizos</a></li>
            <li><a href="#"><i data-lucide="music"></i> Solo Fiestas</a></li>
            <li><a href="#"><i data-lucide="users"></i> Clientes</a></li>
            <li><a href="#"><i data-lucide="bar-chart-3"></i> Reportes</a></li>
            <li><a href="#"><i data-lucide="settings"></i> Configuración</a></li>
        </ul>
    </nav>
</aside>
