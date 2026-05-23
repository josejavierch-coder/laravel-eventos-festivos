@props([
    'image' => '',
    'title' => '',
    'date' => ''
])

<div {{ $attributes->merge(['class' => 'event-card']) }}>
    <div class="event-image">
        <img src="{{ $image }}" alt="{{ $title }}">
    </div>
    <div class="event-info">
        <h4>{{ $title }}</h4>
        <p><i data-lucide="calendar"></i> {{ $date }}</p>
    </div>
</div>
