@props(['disabled' => false, 'class' => '',])


<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-xl border-gray-300 border-blue-500 border-blue-600 ring-blue-500  rounded-md shadow-sm '. $class ]) !!}>
