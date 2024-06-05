@props(['value', 'required' => false,])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-navy-night']) }}>
    {{ $value ?? $slot }} @if ($required) <span class="text-red-500">*</span> @endif
</label>
