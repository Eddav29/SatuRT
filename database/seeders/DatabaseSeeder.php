<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PendudukSeeder::class,
            KeuanganSeeder::class,
            DetailKeuanganSeeder::class,
            StatusSeeder::class,
            // PengajuanSeeder::class,
            // PelaporanSeeder::class,
            // PersuratanSeeder::class,
            UMKMSeeder::class,
            InformasiSeeder::class,
            KriteriaAlternatifSeeder::class,
            InventarisSeeder::class,
            InventarisDetailSeeder::class,
        ]);
    }
}
