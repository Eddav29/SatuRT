@props(['disabled' => false, 'class' => ''])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'rounded-md border-gray-300 bg-transparent placeholder:text-xs placeholder:font-light placeholder:text-gray-300 text-sm ring-blue-500 shadow-sm ' .
        $class,
]) !!}>
