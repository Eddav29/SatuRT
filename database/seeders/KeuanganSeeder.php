<?php

namespace Database\Seeders;

use App\Models\Keuangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keuangan::factory()
            ->count(20)
            ->create();
    }
}
