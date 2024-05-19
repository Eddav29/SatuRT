<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Tambah Kegiatan</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Form --}}
            <section>
                <div x-data="{ title: '' }">
                    <form action="{{ route('spk.store') }}" method="POST" class="px-5">
                        @csrf
                        <div class="mt-6">
                            <label for="nama_alternatif"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-medium text-navy-night">
                                Nama Kegiatan</label>
                            <input
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-blue-400 invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm"
                                placeholder="Nama Kegiatan" type="text" id="nama_alternatif" name="nama_alternatif"
                                @input="title = $event.target.value" value="{{ old('nama_alternatif') }}" required />
                        </div>

                        @foreach ($criterias as $criteria)
                            <div x-data="{ open: false }" class="mt-3 relative">
                                <div class="flex items-center">
                                    <label
                                        class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-medium text-navy-night text-sm md:text-base break-words max-w-[15rem] md:max-w-[40rem] lg:max-w-[27rem] xl:max-w-[43rem] 2xl:max-w-[83rem]"
                                        x-text="'Bobot ' + title + ' terhadap kriteria ' + '({{ $criteria->nama_kriteria }})'"
                                        for="nilai_alternatif{{ $criteria->kriteria_id }}"></label>
                                    <button x-on:click="open = !open" type="button"
                                        class="ml-3 w-7 h-7 text-azure-blue">
                                        @svg('heroicon-o-information-circle')
                                    </button>
                                </div>
                                <x-select-criteria-input
                                    lastCriteria="{{ $loop->index < count($criterias) - 2 ? false : true }}"
                                    :criteriaName="$criteria->nama_kriteria" name="nilai_kriteria[{{ $loop->index }}]"
                                    id="kriteria{{ $criteria->kriteria_id }}" />
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
                {{-- End Form --}}
            </section>
        </div>
    </div>

    @push('scripts')
        <script>
            let options = document.querySelectorAll('select option');

            options.forEach(option => {
                if (option.value == 5) {
                    option.setAttribute('selected', 'selected');
                }
            })
        </script>
    @endpush

</x-app-layout>
