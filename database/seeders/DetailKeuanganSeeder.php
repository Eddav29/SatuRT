<?php

namespace Database\Seeders;

use App\Models\DetailKeuangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailKeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=
        [
            [
                'keuangan_id'=> 1,
                'judul' => 'Donasi Bapak Fulan',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 20000,
                'keterangan' => 'Donasi dari Penduduk',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'keuangan_id'=> 2,
                'judul' => 'Iuran tanggal sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 5000,
                'keterangan' => 'Donasi dari Penduduk',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'keuangan_id'=> 3,
                'judul' => 'Donasi Bapak Fulan',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Dana Darurat',
                'nominal' => 75000,
                'keterangan' => 'Donasi dari Penduduk',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'keuangan_id'=> 4,
                'judul' => 'Dari Hamba ALLAH',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => '-',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'keuangan_id'=> 5,
                'judul' => 'Kas Bulan sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 150000,
                'keterangan' => 'Kas bulan ini',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'keuangan_id'=> 6,
                'judul' => 'Membeli Cat',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 50000,
                'keterangan' => 'Cat Dinding',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
        ];
        foreach($data as $item){
            DetailKeuangan::create($item);
        }
    }
}
