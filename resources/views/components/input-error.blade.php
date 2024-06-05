@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @if (is_string($messages))
            <li>{{ $messages }}</li>
        @else
            @foreach ($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        @endif
    </ul>
@endif
