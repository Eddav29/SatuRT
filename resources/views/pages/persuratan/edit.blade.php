<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        @if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin')
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        @endif
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Edit Permohonan Surat Pengantar</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Form --}}
            <section>
                <form action="{{ route('persuratan.update', $persuratan->persuratan_id) }}" method="POST"
                    enctype="multipart/form-data" class="px-5">
                    @csrf
                    @method('PUT')

                    <div>
                        {{-- Field Pemohon --}}
                        <div class="flex flex-col mt-5">
                            <label for="pemohon"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Pemohon</label>
                            <select id="pemohon" name="pemohon" required
                                class="placeholder:font-light placeholder:text-xs invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm text-navy-night">
                            </select>
                        </div>

                        {{-- Field Jenis Surat --}}
                        <div x-data="{ selected: '{{ $persuratan->jenis_surat }}' }" class="flex flex-col mt-5">
                            <label for="jenis_surat"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Keperluan</label>
                            <select id="jenis_surat" name="jenis_surat" required
                                class="placeholder:font-light placeholder:text-xs invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                @change="selected = $event.target.value">
                                <option value="Surat Pengantar KTP"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar KTP' ? 'selected' : '' }}>Mengurus
                                    Kartu Tanda Penduduk</option>
                                <option value="Surat Pengantar Kartu keluarga"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar Kartu keluarga' ? 'selected' : '' }}>
                                    Mengurus Kartu Keluarga</option>
                                <option value="Surat Pengantar Akta Kelahiran"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar Akta Kelahiran' ? 'selected' : '' }}>
                                    Mengurus Akta Kelahiran</option>
                                <option value="Surat Pengantar Akta Kematian"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar Akta Kematian' ? 'selected' : '' }}>
                                    Mengurus Akta Kematian</option>
                                <option value="Surat Pengantar SKCK"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar SKCK' ? 'selected' : '' }}>Mengurus
                                    SKCK</option>
                                <option value="Surat Pengantar Nikah"
                                    {{ $persuratan->jenis_surat == 'Surat Pengantar Nikah' ? 'selected' : '' }}>
                                    Mengurus Persyaratan Nikah</option>
                                <option value="Lainnya" {{ $persuratan->jenis_surat == 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>

                            {{-- Input Tambahan untuk Opsi Lainnya --}}
                            <input type="text" placeholder="Masukkan Keperluan" name="keperluan_lainnya"
                                id="keperluan"
                                class="placeholder:text-gray-300 placeholder:font-light mt-5 required:ring-1 required:ring-red-500 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm"
                                x-show="selected === 'Lainnya'" value="{{ $persuratan->pengajuan->keperluan }}">
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Perbarui</p>
                        </button>
                        <a href="{{ route('persuratan.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                            <p>Batal</p>
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
                const pemohonSelect = document.getElementById('pemohon');

                const response = await fetch(
                    '/api/v1/data-penduduk/keluarga/{{ Auth::user()->penduduk->kartu_keluarga_id }}/anggota');
                const data = await response.json();

                if (data && data.data) {
                    data.data.forEach(element => {
                        const option = document.createElement('option');
                        option.value = element.penduduk_id;
                        option.textContent = element.nama;

                        if ('{{ $persuratan->pengajuan->penduduk_id }}' === element.penduduk_id) {
                            option.selected = true;
                        }

                        pemohonSelect.appendChild(option);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
