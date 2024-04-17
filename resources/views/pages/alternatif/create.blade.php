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

            {{-- Alert --}}
            @if (session('error'))
                <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4 my-8">
                    <div class="flex items-center gap-2 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" />
                        </svg>

                        <strong class="block font-medium"> Terjadi Kesalahan </strong>
                    </div>

                    <p class="mt-2 text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
            @endif
            {{-- End Alert --}}

            {{-- Form --}}
            <section>
                <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data"
                    class="px-5">
                    @csrf
                    <div class="py-6">
                        <label class="sr-only" for="nama_alternatif"></label>
                        <p class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Nama Kegiatan</p>
                        <input
                          class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                          placeholder="Nama Kegiatan"
                          type="text"
                          id="nama_alternatif"
                        />
                      </div>

                    {{-- Button --}}
                    <div class="mt-5 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow font-medium px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <x-heroicon-o-folder-arrow-down class="w-5 h-5" />
                            <p>Simpan</p>
                        </button>
                        <a href="{{ route('spk.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 flex justify-center items-center gap-x-3"><x-heroicon-o-arrow-uturn-left
                                class="w-5 h-5" />
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
                {{-- End Form --}}
            </section>
        </div>
    </div>

</x-app-layout>
