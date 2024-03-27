@props(['active', 'svgIcon', 'iconStyle'])

@php
    $classes =
        $active ?? false
            ? 'border-indigo-400 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
            : 'border-transparent text-gray-400 hover:text-gray-700 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    $classes .= $active ?? true && !isset($svgIcon) ? ' border-b-2' : '';
    $classes .= isset($svgIcon) ? ' flex-col' : ''

@endphp

<a draggable="false"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 select-none text-md font-medium leading-5' . $classes]) }}>
    @if (isset($svgIcon))
        {{-- <{{$svgIcon}}/> --}}
        {{svg($svgIcon, $iconStyle)}}
    @endif
        {{ $slot }}
</a>
