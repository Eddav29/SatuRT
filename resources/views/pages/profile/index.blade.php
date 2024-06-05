<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    @if (Auth::user()->penduduk->user->profile)
                        <img src="{{ asset('storage/images_storage/account_images/' . Auth::user()->penduduk->user->profile) }}"
                            class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('assets/images/default.png') }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="absolute right-11 p-2" :class="profile ? 'block' : 'hidden'">
                    <div class="flex flex-col overflow-hidden rounded-lg ">
                        <x-nav-button :class="'text-red-500'" :href="route('logout')">
                            {{ __('Logout') }}
                        </x-nav-button>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Biodata</h1>
                </div>
            </section>
            {{-- End header --}}

            {{-- Form --}}
            <section>
                <div class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-2 gap-y-5">
                    <div>
                        <h5 class="font-semibold">NIK</h5>
                        <p>{{ Str::mask(optional(Auth::user()->penduduk)->nik ?? '', '*', 6) }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Nama</h5>
                        <p>{{ Auth::user()->penduduk->nama ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Tempat Lahir</h5>
                        <p>{{ Auth::user()->penduduk->tempat_lahir ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Tanggal Lahir</h5>
                        <p>{{ Auth::user()->penduduk->tanggal_lahir->format('Y-m-d') ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Jenis Kelamin</h5>
                        <p>{{ Auth::user()->penduduk->jenis_kelamin ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Pekerjaan</h5>
                        <p>{{ Auth::user()->penduduk->pekerjaan ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Hubungan Dalam Keluarga</h5>
                        <p>{{ Auth::user()->penduduk->status_hubungan_dalam_keluarga ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Perkawinan</h5>
                        <p>{{ Auth::user()->penduduk->status_perkawinan ?? '' }}</p>
                    </div>

                    <div>
                        <h5 class="font-semibold">Kota</h5>
                        <p>{{ Auth::user()->penduduk->kota ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Kecamatan</h5>
                        <p>{{ Auth::user()->penduduk->kecamatan ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Desa/Kelurahan</h5>
                        <p>{{ Auth::user()->penduduk->desa ?? '' }}</p>
                    </div>
                    <div class="grid grid-cols-2 grid-rows-1">
                        <div>
                            <h5 class="font-semibold">RT</h5>
                            <p>{{ Auth::user()->penduduk->nomor_rt ?? '' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">RW</h5>
                            <p>{{ Auth::user()->penduduk->nomor_rw ?? '' }}</p>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Penduduk</h5>
                        <p>{{ Auth::user()->penduduk->status_penduduk ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Pendidikan Terakhir</h5>
                        <p>{{ Auth::user()->penduduk->pendidikan_terakhir ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Golongan Darah</h5>
                        <p>{{ Auth::user()->penduduk->golongan_darah ?? '' }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Agama</h5>
                        <p>{{ Auth::user()->penduduk->agama ?? '' }}</p>
                    </div>

                    <div class="font-semibold md:col-span-2">
                        <h5 class="font-semibold">Foto KTP</h5>
                        <div class="flex items-center justify-center">
                            <div class="w-full lg:w-1/2">
                                <x-image-preview :file="is_null(Auth::user()->penduduk->foto_ktp) ? null : route('storage.ktp', Auth::user()->penduduk->foto_ktp)"  />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="text-align: center" class="mt-4">
                <a href="{{ route('profile.complete-data', Auth::user()->penduduk->penduduk_id ?? '') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Ubah Data
                </a>
            </section>

            {{-- End Form --}}
        </div>
    </div>
</x-profile-layout>
