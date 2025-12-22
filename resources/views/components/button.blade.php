@props(['variant' => 'primary', 'type' => 'submit'])

@php
$classes = match($variant) {
    'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
    'danger' => 'bg-red-600 text-white hover:bg-red-700',
    default => 'bg-blue-600 text-white hover:bg-blue-700',
};
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "px-4 py-2 rounded $classes"]) }}>
    {{ $slot }}
</button>
