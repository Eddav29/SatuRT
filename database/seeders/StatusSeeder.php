<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::factory()->create([
            'nama' => 'Menunggu Persetujuan'
        ]);

        Status::factory()->create([
            'nama' => 'Diterima'
        ]);

        Status::factory()->create([
            'nama' => 'Ditolak'
        ]);

        Status::factory()->create([
            'nama' => 'Dibatalkan'
        ]);
    }
}
