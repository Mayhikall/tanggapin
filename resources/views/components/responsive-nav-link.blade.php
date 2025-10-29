@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-medium text-white bg-green-700 focus:outline-none focus:text-white focus:bg-green-800 focus:border-green-100 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-green-100 hover:text-white hover:bg-green-700 hover:border-green-400 focus:outline-none focus:text-white focus:bg-green-700 focus:border-green-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
