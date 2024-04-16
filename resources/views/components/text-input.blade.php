@props(['disabled' => false, 'class' => '',])


<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-xl border-gray-300 ring-blue-500 shadow-sm '. $class ]) !!}>
