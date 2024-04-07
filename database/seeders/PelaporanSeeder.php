<?php

namespace Database\Seeders;

use App\Models\Pelaporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelaporan::factory()
            ->count(30)
            ->create();
    }
}
