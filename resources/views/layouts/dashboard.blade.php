<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.meta')
    <title>@yield('title', 'Panel de Control - EventosFestivos')</title>
    @push('head-scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="dashboard-body @yield('body-class')">
    @include('partials.sidebar')

    <main class="dashboard-main">
        <header class="dashboard-header">
            <h1>@yield('page-title', 'Panel de Control')</h1>
            <div class="header-user-actions">
                <div class="notification-bell">
                    <i data-lucide="bell"></i>
                </div>
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&q=80" alt="User" class="user-profile-thumb">
            </div>
        </header>

        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
