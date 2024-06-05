<?php

namespace Database\Seeders;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Storage::disk('storage_ktp')->delete(Storage::disk('storage_ktp')->allFiles());


        User::all()->each(function ($user) {
            $kk = KartuKeluarga::factory()->create();
            Penduduk::factory()->create([
                'kartu_keluarga_id' => $kk->kartu_keluarga_id,
                'user_id' => $user->user_id,
                'status_hubungan_dalam_keluarga' => 'Kepala Keluarga',
                'foto_ktp' => function () {
                    $imagePath = public_path('assets/images/ktp.png');
                    $imageContent = file_get_contents($imagePath);
                    $hashedName = md5($imageContent) . '.png';
                    Storage::disk('storage_ktp')->put($hashedName, $imageContent);
                    return $hashedName;
                },
            ]);
        });

        User::factory(rand(3, 6))->create(
            ['role_id' => Role::where('role_name', 'Penduduk')->first()->role_id]
        )->each(function ($user) {
            $kk = KartuKeluarga::factory()->create();
            Penduduk::factory()->create([
                'kartu_keluarga_id' => $kk->kartu_keluarga_id,
                'user_id' => $user->user_id,
                'status_hubungan_dalam_keluarga' => 'Kepala Keluarga',
            ]);
        });


        KartuKeluarga::all()->each(function ($kk) {
            Penduduk::factory(rand(2, 12))->create([
                'kartu_keluarga_id' => $kk->kartu_keluarga_id,
            ]);
        });

        $kk = KartuKeluarga::create([
            'nomor_kartu_keluarga' => '1234567890111909',
            'kota' => 'TESTING KOTA',
            'kecamatan' => 'TESTING KECAMATAN',
            'desa' => 'TESTING KELURAHAN',
            'alamat' => 'TESTING ALAMAT',
            'nomor_rt' => 1,
            'nomor_rw' => 1,
            'kode_pos' => 12345,
        ]);

        Penduduk::create([
            'kartu_keluarga_id' => $kk->kartu_keluarga_id,
            'nik' => '1234567890111303',
            'nama' => 'TESTING NAMA',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'PEKERJAAN',
            'golongan_darah' => 'A',
            'agama' => 'Islam',
            'tempat_lahir' => 'TESTING TEMPAT LAHIR',
            'tanggal_lahir' => '2022-01-01',
            'status_hubungan_dalam_keluarga' => 'Kepala Keluarga',
            'status_perkawinan' => 'Belum Kawin',
            'pendidikan_terakhir' => 'SMA',
            'status_penduduk' => 'Domisili',
            'nomor_rt' => 1,
            'nomor_rw' => 1,
            'desa' => 'TESTING KELURAHAN',
            'kecamatan' => 'TESTING KECAMATAN',
            'kota' => 'TESTING KOTA',
            'status_kehidupan' => 'Hidup',
        ]);
    }
}
