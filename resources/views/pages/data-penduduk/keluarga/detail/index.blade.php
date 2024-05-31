<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div>
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        </div>
        <div class="p-6 rounded-xl bg-white-snow mt-5 flex flex-col gap-y-7">
            <div>
                <x-heading text="Data Kartu Keluarga" />
                @include('pages.data-penduduk.keluarga.detail.partials.data-keluarga-detail')
            </div>
            <div>
                <x-heading text="Data Anggota Keluarga" />
                @include('pages.data-penduduk.keluarga.detail.partials.data-anggota-keluarga')
                @if (Auth::user()->role->role_name == 'Ketua RT')
                    {{-- Back Button --}}
                    <div>
                        <a href="{{ route('data-keluarga.index') }}"
                            draggable="false"
                            class="select-none bg-white text-black border border-gray-300 px-4 py-2 rounded-md text-sm">Kembali</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
