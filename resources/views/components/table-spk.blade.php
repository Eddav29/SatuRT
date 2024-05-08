@props(['columns', 'title', 'data', 'withAlternative' => false, 'alternatives'])

<div class="grid grid-cols-2 justify-center items-center mt-10">
    <h1 class="text-lg font-bold">{{ $title }}</h1>
    <div class="flex justify-end items-center">
        <a href=""
            class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
    </div>
</div>
<div class="overflow-x-auto">
    <table class="mt-6 table-auto rounded-t-xl overflow-hidden w-max md:w-full">
        <thead>
            <tr class="text-left bg-blue-gray ">
                @foreach ($columns as $column)
                    <th class="p-5">{{ $column['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- @dd($data) --}}
            @foreach ($data as $key => $row)
                @dd($key)
                <tr>
                    @if ($withAlternative)
                        @foreach ($alternatives as $alternatif)
                            <td class="p-5">{{ $alternatives->nama_alternatif }}</td>
                        @endforeach
                    @endif

                    @foreach ($data[$key] as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
