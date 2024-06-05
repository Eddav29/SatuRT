@props(['active', 'svgIcon', 'iconStyle' => 'w-6 h-6'])

@php
    $classes =
        $active ?? false
            ? 'border-azure-blue md:border-navy-night text-azure-blue md:text-gray-900 focus:outline-none transition duration-150 ease-in-out'
            : 'border-transparent text-gray-400 hover:text-gray-700 focus:outline-none focus:text-gray-700 hover:scale-105 focus:border-gray-300 transition duration-150 ease-in-out';

    $classes .= $active ?? true && !isset($svgIcon) ? ' border-b-2 md:border-navy-night border-azure-blue' : '';
    $classes .= isset($svgIcon) ? ' flex-col' : '';

@endphp

<a draggable="false"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 select-none text-md font-medium leading-5 max-md:hover:text-azure-blue hover:scale-105' . $classes]) }}>
    @if (isset($svgIcon))
        {{ svg($svgIcon, $iconStyle) }}
    @endif
    {{ $slot }}
</a>
