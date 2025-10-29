@props(['status'])

@php
$classes = match($status) {
    'pending' => 'bg-yellow-100 text-yellow-800',
    'approved' => 'bg-green-100 text-green-800', 
    'rejected' => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800'
};
@endphp

<span {{ $attributes->merge(['class' => $classes . ' text-xs font-medium px-2.5 py-0.5 rounded-full']) }}>
    {{ ucfirst($status) }}
</span>