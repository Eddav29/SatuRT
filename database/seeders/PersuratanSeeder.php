<?php

namespace Database\Seeders;

use App\Models\Persuratan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersuratanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persuratan::factory()
            ->count(10)
            ->create();
    }
}
