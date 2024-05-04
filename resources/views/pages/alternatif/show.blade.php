<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Detail Bobot Kegiatan</h1>
                </div>
            </section>
            {{-- End Header --}}

            <section>
                <div class="overflow-auto">
                    <table class="mt-6 table-auto w-full rounded-t-xl overflow-hidden">
                        <thead>
                            <tr class="text-left bg-blue-gray ">
                                <th class="p-5">Kegiatan</th>
                                @foreach ($alternative as $criteria)
                                    <th class="p-5 truncate">{{ $criteria->kriteria->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-5">{{ $alternative[0]->alternatif->nama_alternatif }}</td>
                                @foreach ($alternative as $weight)
                                    <td class="p-5">{{ $weight->nilai }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    {{-- Content End --}}
</x-app-layout>
