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
        DetailKeuangan::factory()
            ->count(1000)
            ->create();
    }
}
