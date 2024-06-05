<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailKeuangan>
 */
class DetailKeuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'keuangan_id' => $this->faker->numberBetween(1, 10),
            'judul' => $this->faker->sentence(),
            'jenis_keuangan' => $this->faker->randomElement(['Pemasukan', 'Pengeluaran']),
            'asal_keuangan' => $this->faker->randomElement(['Donasi', 'Iuran Warga', 'Kas Umum', 'Dana Darurat', 'Lainnya']),
            'nominal' => $this->faker->numberBetween(100000, 1000000),
            'keterangan' => $this->faker->sentence(),
            'created_at' => Carbon::createFromTimestamp(
                $this->faker->dateTimeBetween('2019-01-01', now())->getTimestamp()
            ),
            'updated_at' => Carbon::createFromTimestamp(
                $this->faker->dateTimeBetween('2019-01-01', now())->getTimestamp()
            ),
        ];
    }
}
