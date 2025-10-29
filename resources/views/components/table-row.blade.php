@props(['class' => ''])

<tr {{ $attributes->merge(['class' => 'even:bg-gray-50 hover:bg-gray-50 ' . $class]) }}>
    {{ $slot }}
</tr>