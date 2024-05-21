<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5  mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl  bg-white-snow overflow-hidden">
            <section>
                <x-datatables id="user_id" url="/data-akun/penduduk" :columns="[
                    [
                        'label' => 'NIK',
                        'key' => 'nik',
                        'style' => 'text-left'
                    ],
                    [
                        'label' => 'Username',
                        'key' => 'user.username',
                        'style' => 'text-left'
                    ],
                    [
                        'label' => 'Email',
                        'key' => 'user.email',
                        'style' => 'text-left'
                    ],
                    // [
                    //     'label' => 'Pemilik',
                    //     'key' => 'nama',
                    //     'style' => 'text-left'
                    // ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]">
                </x-datatables>
            </section>
        </div>
    </div>
</x-app-layout>
