@props([
    'color' => 'teal',
    'icon' => 'party-popper',
    'title' => '',
    'description' => '',
    'buttonText' => 'Planificar'
])

<div {{ $attributes->merge(['class' => "category-card card-{$color}"]) }}>
    <div class="card-icon">
        <i data-lucide="{{ $icon }}"></i>
    </div>
    <h3>{{ $title }}</h3>
    <p>{{ $description }}</p>
    <button class="btn btn-card">{{ $buttonText }}</button>
</div>
