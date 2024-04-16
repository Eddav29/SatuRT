@props(['list', 'url' => []])

@php
    $lastList = array_pop($list);
    $lastUrl = $url[count($url) - 1];
@endphp

<nav aria-label="Breadcrumb" class="mt-2">
    <ol class="flex items-center gap-1 text-sm text-gray-600">

        @foreach ($list as $key => $value)
            <li>
                <a href="
                @if (is_array($url[$key]))
                    {{ route($url[$key][0], $url[$key][1]) }}
                @else
                    {{ route($url[$key]) }}
                @endif
                " class="block transition hover:text-gray-700">
                    <span> {{ $value }} </span>
                </a>
            </li>

            <li class="rtl:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </li>
        @endforeach

        <li>
            <a href="
            @if (is_array($lastUrl))
                {{ route($lastUrl[0], $lastUrl[1]) }}
            @else
                {{ route($lastUrl) }}
            @endif
            " class="block transition hover:text-gray-700"> {{ $lastList }} </a>
        </li>
    </ol>
</nav>
