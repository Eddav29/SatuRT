@props([
    'stepTitle',
    'data',
    'setColumnAs' => 'Kriteria',
    'columns',
    'withAlternative' => false,
    'alternatives',
    'emptyColumn' => false,
    'withWeight' => false,
    'weights',
    'startIndex' => 0,
    'withGuide' => true,
])

<div class="flex justify-between items-center mt-10">
    <div x-data="{ formula: '' }" class="flex justify-end items-center relative">
        <h1 class="text-lg font-bold">{{ $stepTitle }}</h1>
        @if ($withGuide)
            <button @click.prevent="formula = '{{ $stepTitle }}'" class="ml-3 w-7 h-7 text-azure-blue">
                @svg('heroicon-o-information-circle')
            </button>
            <div @click.outside="formula = ''" x-show="formula == '{{ $stepTitle }}'"
                class="rounded-2xl border border-blue-100 bg-white p-4 shadow-lg sm:p-6 lg:p-8 absolute top-0 left-0 w-[21rem] md:w-[30rem] z-50"
                role="alert">
                <div class="flex items-center gap-4">
                    <span class="shrink-0 rounded-full bg-blue-400 p-2 text-white">
                        <svg class="h-4 w-4" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"
                                fill-rule="evenodd" />
                        </svg>
                    </span>

                    <p class="font-medium sm:text-lg">Rumus {{ $stepTitle }}</p>
                </div>

                <div class="mt-4 text-gray-500 flex flex-col gap-y-5 overflow-x-auto">
                    {{ $slot }}
                </div>
            </div>
        @endif
    </div>
</div>

<div class="overflow-x-auto">
    <table class="mt-6 table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
        <thead>
            <tr class="text-left bg-blue-gray ">
                @if ($emptyColumn)
                    <th class="p-5 truncate"></th>
                @endif

                @if ($setColumnAs === 'Custom')
                    @foreach ($columns as $column)
                        <th class="p-5 truncate">{{ $column }}</th>
                    @endforeach
                @else
                    @foreach ($columns as $column)
                        <th class="p-5 truncate">{{ $column }}</th>
                    @endforeach
                @endif
            </tr>

            @if ($withWeight)
                @php
                    $total_column = count($columns);
                @endphp
                <tr class="text-left bg-blue-gray p-5 ">
                    @if ($emptyColumn)
                        <th class="p-5 truncate"></th>
                    @endif
                    <th colspan="{{ $total_column }}" class="p-5 text-center bg-yellow-200">Bobot</th>
                </tr>
                <tr class="text-left bg-blue-gray ">
                    @if ($emptyColumn)
                        <th class="p-5 truncate"></th>
                    @endif
                    @foreach ($weights as $weight)
                        <th class="px-5 truncate bg-yellow-200">{{ $weight }}</th>
                    @endforeach
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach ($data as $key => $row)
                <tr>
                    @if ($withAlternative)
                        <td class="p-5 truncate">
                            {{ $alternatives[$key] }}
                        </td>
                    @endif
                    @foreach ($row as $key => $value)
                        <td class="p-5 truncate">{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
