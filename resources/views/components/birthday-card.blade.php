@props([
    'name' => '',
    'date' => '',
    'location' => '',
    'theme' => '',
    'status' => 'active',
    'statusLabel' => 'Active'
])

<div {{ $attributes->merge(['class' => 'birthday-card']) }}>
    <div class="card-top">
        <div class="status-indicator">
            <div class="status-icon {{ $status }}"><i data-lucide="{{ $status === 'active' ? 'party-popper' : 'alert-circle' }}"></i></div>
            @if($statusLabel)
                <span class="status-label {{ $status }}">{{ $statusLabel }}</span>
            @endif
        </div>
        <div class="card-actions-menu">
            <i data-lucide="more-vertical" class="menu-trigger"></i>
            <div class="card-dropdown" style="display: none;">
                <ul>
                    <li><a href="#">Ver Detalles <i data-lucide="chevron-down" style="width: 12px;"></i></a></li>
                    <li><a href="#">Editar</a></li>
                    <li><a href="#">Cancelar</a></li>
                </ul>
            </div>
        </div>
    </div>
    <h3>{{ $name }}</h3>
    <div class="card-info-item"><i data-lucide="calendar"></i> {{ $date }}</div>
    <div class="card-info-item"><i data-lucide="map-pin"></i> {{ $location }}</div>
    <div class="card-theme">Temática: {{ $theme }}</div>
    <div class="trash-btn"><i data-lucide="trash-2"></i></div>
</div>
