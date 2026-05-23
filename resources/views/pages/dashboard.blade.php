@extends('layouts.admin')

@section('title', 'Dashboard - EventosFestivos')
@section('header_title', 'Vista General')

@section('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-value { font-size: 1.8rem; font-weight: 800; color: #2d3748; }
    .stat-label { font-size: 0.85rem; color: #718096; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .chart-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #edf2f7;
    }
    .chart-card h2 { font-size: 1rem; color: #2d3748; margin-bottom: 15px; font-weight: 700; border-left: 4px solid var(--color-teal); padding-left: 10px; }
    .chart-container { position: relative; height: 220px; width: 100%; }

    @media (max-width: 768px) {
        .chart-container { height: 180px; }
    }
</style>
@endsection

@section('content')
    <!-- Indicadores Superiores -->
    <div class="dashboard-grid" style="margin-bottom: 25px;">
        <div class="stat-card">
            <div>
                <p class="stat-label">Eventos</p>
                <div class="stat-value">{{ \App\Models\EventoFestivo::count() }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(38, 186, 157, 0.1); color: var(--color-teal);">
                <i data-lucide="party-popper" size="24"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-label">Categorías</p>
                <div class="stat-value">{{ \App\Models\Categoria::where('estado', true)->count() }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: var(--color-blue);">
                <i data-lucide="layers" size="24"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-label">Salones</p>
                <div class="stat-value">{{ \App\Models\Salon::where('estado', true)->count() }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(230, 126, 34, 0.1); color: var(--color-orange);">
                <i data-lucide="map-pin" size="24"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-label">Usuarios</p>
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(192, 40, 130, 0.1); color: var(--color-pink);">
                <i data-lucide="users" size="24"></i>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
        <div class="chart-card">
            <h2>Actividad Semanal</h2>
            <div class="chart-container">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h2>Eventos por Categoría</h2>
            <div class="chart-container">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="chart-card" style="grid-column: span 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 style="margin-bottom: 0;">Últimos Eventos</h2>
                <a href="{{ route('admin.eventos.index') }}" style="font-size: 0.8rem; color: var(--color-teal); font-weight: 600;">Ver Todos</a>
            </div>
            <div class="table-responsive">
                <table class="event-table">
                    <thead>
                        <tr style="font-size: 0.75rem; color: #a0aec0;">
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\EventoFestivo::latest()->take(5)->get() as $evento)
                            <tr style="font-size: 0.85rem;">
                                <td style="padding: 10px 0;"><strong>{{ Str::limit($evento->titulo, 20) }}</strong></td>
                                <td style="color: #718096;">{{ $evento->fecha_evento ? $evento->fecha_evento->format('d/m/y') : 'N/A' }}</td>
                                <td>
                                    <span style="display:inline-block; width: 8px; height: 8px; border-radius: 50%; background: {{ $evento->estado ? '#26ba9d' : '#cbd5e0' }};"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Gráfico de Actividad Semanal
    const ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctxWeekly, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            datasets: [{
                label: 'Reservas',
                data: [12, 19, 3, 5, 2, 3, 10],
                borderColor: '#26ba9d',
                backgroundColor: 'rgba(38, 186, 157, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Gráfico de Categorías
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: ['Cumpleaños', 'Bodas', 'Corporativos', 'Otros'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#26ba9d', '#e67e22', '#3498db', '#c02882'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            },
            cutout: '70%'
        }
    });
</script>
@endsection
