<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Pengajuan Surat Pengantar</h1>
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
                <form action="{{ route('persuratan.store') }}" method="POST" enctype="multipart/form-data"
                    class="px-5">
                    @csrf

                    <div>
                        {{-- Field Jenis Keperluan --}}
                        <div class="flex flex-col mt-5">
                            <label for="pemohon"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Pemohon</label>
                            <select id="pemohon" name="pemohon" required
                                class="placeholder:font-light placeholder:text-xs invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm text-navy-night focus:text-navy-night">
                                <option value="Pilih Pemohon">Pilih Pemohon</option>
                            </select>
                            <input type="text" placeholder="Masukkan Keperluan" name="keperluan" id="keperluan"
                                class="placeholder:text-gray-300 placeholder:font-light mt-5 required:ring-1 required:ring-red-500 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm hidden">
                        </div>
                    </div>

                    <div x-data="{ selected: 'Pilih Jenis keuangan' }">
                        {{-- Field Jenis Keperluan --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_keuangan"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Keperluan</label>
                            <select id="jenis_surat" name="jenis_surat" required
                                class="placeholder:font-light placeholder:text-xs invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-navy-night text-sm"
                                @change="selected = $event.target.value">
                                <option value="Pilih Jenis keuangan">Pilih Jenis Keperluan</option>
                                <option value="Surat Pengantar KTP">Mengurus Kartu Tanda Penduduk</option>
                                <option value="Surat Pengantar Kartu keluarga">Mengurus Kartu Keluarga</option>
                                <option value="Surat Pengantar Akta Kelahiran">Mengurus Akta Kelahiran</option>
                                <option value="Surat Pengantar Akta Kematian">Mengurus Akta Kematian</option>
                                <option value="Surat Pengantar SKCK">Mengurus SKCK</option>
                                <option value="Surat Pengantar Nikah">Mengurus Persyaratan Nikah</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            {{-- Input Tambahan untuk Opsi Lainnya --}}
                            <input type="text" placeholder="Masukkan Keperluan" name="keperluan_lainnya" id="keperluan"
                                class="placeholder:text-gray-300 placeholder:font-light mt-5 required:ring-1 required:ring-red-500 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm"
                                x-show="selected === 'Lainnya'">
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Kirim</p>
                        </button>
                        <a href="{{ route('persuratan.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
                {{-- End Form --}}
            </section>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                const data = await fetchData();

                if (data) {
                    const pemohon = document.getElementById('pemohon');
                    data.data.forEach(element => {
                        const option = document.createElement('option');
                        option.value = element.penduduk_id;
                        option.textContent = element.nama;
                        pemohon.appendChild(option);
                    });
                }
            })


            const fetchData = async () => {
                const response = await fetch(
                    '/api/v1/data-penduduk/keluarga/{{ Auth::user()->penduduk->kartu_keluarga_id }}/anggota');
                const data = await response.json();
                return data;
            }
        </script>
    @endpush
</x-app-layout>