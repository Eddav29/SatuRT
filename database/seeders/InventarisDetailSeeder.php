<?php

namespace Database\Seeders;

use App\Models\Inventaris_Detail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarisDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventaris_Detail::factory()
            ->count(10)
            ->create();
    }
}
