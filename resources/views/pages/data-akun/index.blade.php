<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="bg-white mx-6 md:mx-14 my-10 px-6 py-4">
        <x-datatables
        id="user_id"
        url="/data-akun/penduduk"
        :columns="[
            [
                'label' => 'NIK Kepala Keluarga',
                'key' => 'nik',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'Username',
                'key' => 'user.username',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'Email',
                'key' => 'user.email',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'Pemilik',
                'key' => 'nama',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
        ]" :aksi="[
            'detail' => true,
            'edit' => true,
            'hapus' => true,
        ]">
        </x-datatables>
    </section>
</x-app-layout>
