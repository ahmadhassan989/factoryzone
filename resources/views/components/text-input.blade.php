@props(['id', 'type' => 'text', 'name', 'value' => null])

@php
    $classes = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm';
@endphp

<input
    id="{{ $id }}"
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->merge(['class' => $classes]) }}
/>

