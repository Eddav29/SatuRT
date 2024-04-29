@props(['active', 'svgIcon', 'iconStyle', 'class' => ''])

@php
    $classes =
        $active ?? false
            ? ' font-semibold text-azure-blue bg-blue-gray shadow-[0_0_3px_0_rgba(0,0,0,0.1)] focus:outline-none transition duration-150 ease-in-out'
            : ' font-medium border-transparent text-navy-night/30 hover:text-gray-700 focus:outline-none focus:text-gray-700 hover:scale-105 focus:border-gray-300 transition duration-150 ease-in-out';
    $classes .= $active ?? true && !isset($svgIcon) ? 'md:border-navy-night border-azure-blue rounded-md' : '';
@endphp

<a draggable="false"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-3 gap-x-3 select-none text-xs md:text-base w-full leading-5 max-md:hover:text-azure-blue hover:scale-105' . $classes . ' ' . $class]) }}>
    @if (isset($svgIcon))
        {{ svg($svgIcon, $iconStyle) }}
    @endif
    {{ $slot }}
</a>
