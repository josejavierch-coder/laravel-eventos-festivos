@props([
    'title' => '',
    'value' => ''
])

<div {{ $attributes->merge(['class' => 'stat-card']) }}>
    <div class="stat-info">
        <h3>{{ $title }}</h3>
        <div class="stat-value">{{ $value }}</div>
    </div>
    @if($slot->isNotEmpty())
        <div class="stat-mini-chart">
            {{ $slot }}
        </div>
    @endif
</div>
