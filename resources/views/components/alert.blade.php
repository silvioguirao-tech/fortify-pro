@props(['type' => 'info'])

@php
$classes = match($type) {
    'success' => 'bg-green-100 text-green-800 border-green-200',
    'error' => 'bg-red-100 text-red-800 border-red-200',
    default => 'bg-blue-100 text-blue-800 border-blue-200',
};
@endphp

<div {{ $attributes->merge(['class' => "border-l-4 p-4 rounded $classes"]) }}>
    {{ $slot }}
</div>
