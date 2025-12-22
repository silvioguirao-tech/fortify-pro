@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white p-6 rounded-lg shadow $class"]) }}>
    {{ $slot }}
</div>
