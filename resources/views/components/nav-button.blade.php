@props(['theme' => 'light', 'class' => ''])

@php
    $classes = $theme == 'light' ? ' bg-white text-gray-800 ' : ' bg-gray-800 text-white ';
@endphp

<a draggable="false"
    {{ $attributes->merge(['class' => 'select none inline-flex items-center px-8 py-3 md:px-10 md:py-3 font-semibold text-sm md:text-md leading-5 transition duration-150 ease-in-out ' . $classes . ' ' . $class]) }}>
    {{ $slot }}
</a>
