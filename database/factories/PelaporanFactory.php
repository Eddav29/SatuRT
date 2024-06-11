<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelaporan>
 */
class PelaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'pengajuan_id' => Pengajuan::pluck('pengajuan_id')->unique()->random(),
            // 'jenis_pelaporan' => $this->faker->randomElement([
            //     'Pengaduan',
            //     'Kritik',
            //     'Saran',
            //     'Lainnya'
            // ]),
        ];
    }
}
