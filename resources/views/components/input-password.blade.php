@props(['name', 'label', 'required' => false, 'placeholder' => '********', 'value' => null])

<x-input-label for="{{ $name }}" :value="__($label)" :required="$required" />
<div class="w-full relative" x-data="{ type: 'password' }">
    <x-input-text id="{{ $name }}" class="block mt-1 w-full" x-bind:type="type" :required="$required"
        placeholder="{{ $placeholder }}" :value="$value" name="{{ $name }}" />
    <div class="absolute z-20 inset-y-0 right-0 pr-3 flex justify-center items-center text-sm leading-5" x-cloak>
        <button type="button" x-on:click="type = type === 'password' ? 'text' : 'password'"
            class="text-gray-500 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            <x-heroicon-o-eye class="w-6 h-6" x-show="type === 'password'" />
            <x-heroicon-o-eye-slash class="w-6 h-6" x-show="type === 'text'" />
        </button>
    </div>
</div>
<x-input-error :messages="$errors->get($name)" class="mt-2" />
