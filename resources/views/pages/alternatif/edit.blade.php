<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- @dd($alternatif) --}}

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Edit Kegiatan</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Form --}}
            <section>
                <div x-data="{ title: '' }">
                    <form action="{{ route('spk.update', $id) }}" method="POST" class="px-5">
                        @csrf
                        @method('PUT')
                        <div class="mt-6">
                            <label for="nama_alternatif"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-medium text-navy-night">
                                Nama Kegiatan</label>
                            <input
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-blue-400 invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm"
                                placeholder="Nama Kegiatan" type="text" id="nama_alternatif" name="nama_alternatif"
                                @input="title = $event.target.value"
                                value="{{ $alternatif[0]->alternatif->nama_alternatif ?? old('nama_alternatif') }}"
                                required />
                        </div>

                        @foreach ($alternatif as $criteria)
                            <div class="mt-3">
                                <label
                                    class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-medium text-navy-night text-sm md:text-base break-words"
                                    x-text="'Bobot ' + title + ' ' + '({{ $criteria->kriteria->nama_kriteria }})'"
                                    for="nilai_alternatif{{ $criteria->kriteria->kriteria_id }}"></label>
                                <input
                                    class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-blue-400 invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm"
                                    placeholder="Bobot {{ $criteria->kriteria->nama_kriteria }}" type="text"
                                    id="nilai_alternatif{{ $criteria->kriteria->kriteria_id }}"
                                    name="nilai_kriteria[{{ $loop->index }}]"
                                    value="{{ $criteria->nilai ?? old('nilai_kriteria.' . $loop->index) }}" required />
                            </div>
                        @endforeach

                        {{-- Button --}}
                        <div class="mt-10 flex gap-x-5">
                            <button type="submit"
                                class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                                <p>Simpan</p>
                            </button>
                            <a href="{{ route('spk.index') }}"
                                class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                                <p>Kembali</p>
                            </a>
                        </div>
                    </form>
                </div>
            </section>
            {{-- End Form --}}
        </div>
    </div>
</x-app-layout>
