<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KartuKeluarga>
 */
class KartuKeluargaFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_kartu_keluarga' => $this->faker->unique()->numerify('################'),
            'nomor_rt' => $this->faker->numberBetween(1, 99),
            'nomor_rw' => $this->faker->numberBetween(1, 99),
            'alamat' => $this->faker->city(),
            'desa' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'kota' => $this->faker->city(),
            'kode_pos' => $this->faker->numberBetween(65142, 65142),
        ];
    }
}
