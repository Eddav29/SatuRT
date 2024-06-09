<?php

namespace Database\Seeders;

use App\Models\DetailKeuangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DetailKeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'keuangan_id' => 1,
                'judul' => 'Donasi Bapak Fulan',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 20000,
                'keterangan' => 'Donasi dari Penduduk',
                'created_at' => Carbon::parse('2024-01-05'),
                'updated_at' => Carbon::parse('2024-01-05')
            ],
            [
                'keuangan_id' => 2,
                'judul' => 'Iuran tanggal sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 5000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2024-01-10'),
                'updated_at' => Carbon::parse('2024-01-10')
            ],
            [
                'keuangan_id' => 3,
                'judul' => 'Donasi Bapak Fulan',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Dana Darurat',
                'nominal' => 75000,
                'keterangan' => 'Donasi dari Penduduk',
                'created_at' => Carbon::parse('2024-01-15'),
                'updated_at' => Carbon::parse('2024-01-15')
            ],
            [
                'keuangan_id' => 4,
                'judul' => 'Dari Hamba ALLAH',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Hamba ALLAH',
                'created_at' => Carbon::parse('2024-01-20'),
                'updated_at' => Carbon::parse('2024-01-20')
            ],
            [
                'keuangan_id' => 5,
                'judul' => 'Kas Bulan sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 150000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2024-01-25'),
                'updated_at' => Carbon::parse('2024-01-25')
            ],
            [
                'keuangan_id' => 6,
                'judul' => 'Membeli Cat',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 50000,
                'keterangan' => 'Cat Dinding',
                'created_at' => Carbon::parse('2024-01-30'),
                'updated_at' => Carbon::parse('2024-01-30')
            ],
            [
                'keuangan_id' => 7,
                'judul' => 'Pembayaran Listrik',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 50000,
                'keterangan' => 'Pembayaran listrik',
                'created_at' => Carbon::parse('2024-02-05'),
                'updated_at' => Carbon::parse('2024-02-05')
            ],
            [
                'keuangan_id' => 8,
                'judul' => 'Donasi Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 300000,
                'keterangan' => 'Donasi warga sekitar',
                'created_at' => Carbon::parse('2024-02-10'),
                'updated_at' => Carbon::parse('2024-02-10')
            ],
            [
                'keuangan_id' => 9,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 50000,
                'keterangan' => 'Iuran bulanan warga',
                'created_at' => Carbon::parse('2024-02-15'),
                'updated_at' => Carbon::parse('2024-02-15')
            ],
            [
                'keuangan_id' => 10,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2024-02-20'),
                'updated_at' => Carbon::parse('2024-02-20')
            ],
            [
                'keuangan_id' => 11,
                'judul' => 'Donasi Bapak Ahmad',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Bapak Ahmad',
                'created_at' => Carbon::parse('2024-02-25'),
                'updated_at' => Carbon::parse('2024-02-25')
            ],
            [
                'keuangan_id' => 12,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2024-03-05'),
                'updated_at' => Carbon::parse('2024-03-05')
            ],
            [
                'keuangan_id' => 13,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2024-03-10'),
                'updated_at' => Carbon::parse('2024-03-10')
            ],
            [
                'keuangan_id' => 14,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2024-03-15'),
                'updated_at' => Carbon::parse('2024-03-15')
            ],
            [
                'keuangan_id' => 15,
                'judul' => 'Donasi Hamba Allah',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Hamba Allah',
                'created_at' => Carbon::parse('2024-03-20'),
                'updated_at' => Carbon::parse('2024-03-20')
            ],
            [
                'keuangan_id' => 16,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2024-03-25'),
                'updated_at' => Carbon::parse('2024-03-25')
            ],
            [
                'keuangan_id' => 17,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2024-03-30'),
                'updated_at' => Carbon::parse('2024-03-30')
            ],
            [
                'keuangan_id' => 18,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2024-04-05'),
                'updated_at' => Carbon::parse('2024-04-05')
            ],
            [
                'keuangan_id' => 19,
                'judul' => 'Donasi Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari warga sekitar',
                'created_at' => Carbon::parse('2024-04-10'),
                'updated_at' => Carbon::parse('2024-04-10')
            ],
            [
                'keuangan_id' => 20,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2024-04-15'),
                'updated_at' => Carbon::parse('2024-04-15')
            ],
            [
                'keuangan_id' => 21,
                'judul' => 'Donasi Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari warga sekitar',
                'created_at' => Carbon::parse('2023-04-20'),
                'updated_at' => Carbon::parse('2023-04-20')
            ],
            [
                'keuangan_id' => 22,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2023-04-25'),
                'updated_at' => Carbon::parse('2023-04-25')
            ],
            [
                'keuangan_id' => 23,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2023-04-30'),
                'updated_at' => Carbon::parse('2023-04-30')
            ],
            [
                'keuangan_id' => 24,
                'judul' => 'Donasi Hamba Allah',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Hamba Allah',
                'created_at' => Carbon::parse('2023-05-05'),
                'updated_at' => Carbon::parse('2023-05-05')
            ],
            [
                'keuangan_id' => 25,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2023-05-10'),
                'updated_at' => Carbon::parse('2023-05-10')
            ],
            [
                'keuangan_id' => 26,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2023-05-15'),
                'updated_at' => Carbon::parse('2023-05-15')
            ],
            [
                'keuangan_id' => 27,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2023-05-20'),
                'updated_at' => Carbon::parse('2023-05-20')
            ],
            [
                'keuangan_id' => 28,
                'judul' => 'Donasi Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari warga sekitar',
                'created_at' => Carbon::parse('2023-05-25'),
                'updated_at' => Carbon::parse('2023-05-25')
            ],
            [
                'keuangan_id' => 29,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2023-05-30'),
                'updated_at' => Carbon::parse('2023-05-30')
            ],
            [
                'keuangan_id' => 30,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2023-06-05'),
                'updated_at' => Carbon::parse('2023-06-05')
            ],
            [
                'keuangan_id' => 31,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2023-06-10'),
                'updated_at' => Carbon::parse('2023-06-10')
            ],
            [
                'keuangan_id' => 32,
                'judul' => 'Donasi Hamba Allah',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Hamba Allah',
                'created_at' => Carbon::parse('2023-06-15'),
                'updated_at' => Carbon::parse('2023-06-15')
            ],
            [
                'keuangan_id' => 33,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2023-06-20'),
                'updated_at' => Carbon::parse('2023-06-20')
            ],
            [
                'keuangan_id' => 34,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2023-06-25'),
                'updated_at' => Carbon::parse('2023-06-25')
            ],
            [
                'keuangan_id' => 35,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2023-06-30'),
                'updated_at' => Carbon::parse('2023-06-30')
            ],
            [
                'keuangan_id' => 36,
                'judul' => 'Donasi Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari warga sekitar',
                'created_at' => Carbon::parse('2023-07-05'),
                'updated_at' => Carbon::parse('2023-07-05')
            ],
            [
                'keuangan_id' => 37,
                'judul' => 'Iuran Warga',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Iuran Warga',
                'nominal' => 100000,
                'keterangan' => 'Iuran warga bulanan',
                'created_at' => Carbon::parse('2023-07-10'),
                'updated_at' => Carbon::parse('2023-07-10')
            ],
            [
                'keuangan_id' => 38,
                'judul' => 'Kas Bulan Sekian',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Kas bulan ini',
                'created_at' => Carbon::parse('2023-07-15'),
                'updated_at' => Carbon::parse('2023-07-15')
            ],
            [
                'keuangan_id' => 39,
                'judul' => 'Pengeluaran Kegiatan',
                'jenis_keuangan' => 'Pengeluaran',
                'asal_keuangan' => 'Kas Umum',
                'nominal' => 100000,
                'keterangan' => 'Biaya kegiatan',
                'created_at' => Carbon::parse('2023-07-20'),
                'updated_at' => Carbon::parse('2023-07-20')
            ],
            [
                'keuangan_id' => 40,
                'judul' => 'Donasi Hamba Allah',
                'jenis_keuangan' => 'Pemasukan',
                'asal_keuangan' => 'Donasi',
                'nominal' => 100000,
                'keterangan' => 'Donasi dari Hamba Allah',
                'created_at' => Carbon::parse('2023-07-25'),
                'updated_at' => Carbon::parse('2023-07-25')
            ],
        ];

        foreach ($data as $item) {
            DetailKeuangan::create($item);
        }
    }
}
