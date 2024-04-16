<div class="mt-8">
    <x-datatables
    id="penduduk_id"
    url="/data-penduduk/keluarga/{{ $familyCard->kartu_keluarga_id }}/anggota"
    :columns="[

        [
            'label' => 'NIK',
            'key' => 'nik',
            'style' => [
                'text-align' => 'left',
            ],
        ],
        [
            'label' => 'Nama',
            'key' => 'nama',
            'style' => [
                'text-align' => 'left',
            ],
        ],
        [
            'label' => 'Jenis Kelamin',
            'key' => 'jenis_kelamin',
            'style' => [
                'text-align' => 'left',
            ],
        ],
        [
            'label' => 'Hubungan Keluarga',
            'key' => 'status_hubungan_dalam_keluarga',
            'style' => [
                'text-align' => 'left',
            ],
        ],
    ]"
        :aksi="[
            'detail' => true,
            'edit' => true,
            'hapus' => true,
        ]">
    </x-datatables>
</div>
