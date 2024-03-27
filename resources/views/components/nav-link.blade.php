@props(['active', 'icon'])

@php
    $classes =
        $active ?? false
            ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    $classes .= $active ?? true && !isset($icon) ? ' border-b-2' : '';
    $classes .= isset($icon) ? ' flex-col' : ''

@endphp

<a draggable="false"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 select-none text-md font-medium leading-5' . $classes]) }}>
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
</a>
