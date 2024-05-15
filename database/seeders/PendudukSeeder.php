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
    }
}
