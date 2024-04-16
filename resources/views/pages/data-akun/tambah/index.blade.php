<x-app-layout>

    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <section class="bg-white mx-6 md:mx-14 my-10 p-6">
        <form action="{{ route('data-akun.store')}}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <x-heading text="Data Akun Penduduk" />
                    @include('pages.data-akun.partials.data-akun-form')
                </div>
            </div>

            <div class="flex justify-start mt-8 space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                <button type="submit" name="save_and_more" class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Simpan dan Tambah Lagi</button>
                <a href="{{route('data-akun.index')}}" draggable="false" class="select-none bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Kembali</a>
            </div>
        </form>
    </section>

</x-app-layout>
