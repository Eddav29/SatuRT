@props(['type' => 'submit', 'class' => '', ])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none transition ease-in-out duration-150 ' . $class]) }}>
    {{ $slot }}
</button>
