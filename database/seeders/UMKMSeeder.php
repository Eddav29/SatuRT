<?php

namespace Database\Seeders;

use App\Models\UMKM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UMKMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UMKM::factory()
            ->count(10)
            ->create();
    }
}
