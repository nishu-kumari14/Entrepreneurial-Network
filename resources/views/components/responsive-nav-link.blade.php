@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-primary bg-primary/5 hover:bg-primary/10 transition-colors duration-200'
            : 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
