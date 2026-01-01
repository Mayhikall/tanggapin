@props(['status'])

@php
$classes = match($status) {
    'pending' => 'bg-yellow-100 text-yellow-900 border border-yellow-300',
    'approved' => 'bg-green-100 text-green-900 border border-green-300', 
    'rejected' => 'bg-red-100 text-red-900 border border-red-300',
    default => 'bg-gray-100 text-gray-900 border border-gray-300'
};

$text = match($status) {
    'pending' => 'Direview',
    'approved' => 'Disetujui',
    'rejected' => 'Ditolak',
    default => ucfirst($status)
};
@endphp

<span {{ $attributes->merge(['class' => $classes . ' text-xs font-bold px-3 py-1 rounded-full']) }}>
    {{ $text }}
</span>