<?php

namespace Database\Factories;

use App\Models\Inventaris;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Inventaris_DetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inventaris_id' => Inventaris::pluck('inventaris_id')->random(),
            'penduduk_id' => Penduduk::pluck('penduduk_id')->random(),
            'jumlah' => $this->faker->numberBetween(1, 10),
            'kondisi' => $this->faker->randomElement(['Normal', 'Rusak', 'Hilang']),
            'status' => $this->faker->randomElement(['Dipinjam', 'Dikembalikan']),
            'tanggal_pinjam' => $this->faker->date(),
            'tanggal_kembali' => $this->faker->date(),
        ];
    }
}
