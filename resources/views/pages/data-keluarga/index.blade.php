<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow">
            <section>
                <x-datatables url="data-keluarga" :primaryKey="'kartu_keluarga_id'" :columns="[
                    ['label' => 'No. Kartu Keluarga', 'key' => 'nomor_kartu_keluarga'],
                    ['label' => 'NIK Kepala Keluarga', 'key' => 'penduduk[0].nik'],
                    ['label' => 'Nama Kepala Keluarga', 'key' => 'penduduk[0].nama'],
                    ['label' => 'Jumlah Anggota', 'key' => 'penduduk_count'],
                ]">
                </x-datatables>
            </section>
        </div>
    </div>

</x-app-layout>
