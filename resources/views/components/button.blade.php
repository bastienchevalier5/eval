@props(['type' => 'submit', 'color' => 'secondary'])

@php
    $base = 'inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';
    $colors = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "$base {$colors[$color] }"]) }}>
    {{ $slot }}
</button>
