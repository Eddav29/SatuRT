@props(['name', 'checked' => false, 'label' => null])

<div class="inline-flex">

    <input type="checkbox" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-6 h-6 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}
        @if ($checked) checked @endif>

    <label for="{{ $name }}" class="ml-2 text-md text-gray-900">{{ $label }}</label>
</div>
