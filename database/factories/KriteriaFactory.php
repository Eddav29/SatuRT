<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kriteria' => $this->faker->randomElement([
                'Penghasilan',
                'Tanggungan',
                'Tanggungan Anak',
                'Tanggungan Orang Tua',
                'Tanggungan Saudara',
                'Tanggungan Keluarga',
                'Tanggungan Lainnya',
            ]),
            'bobot' => $this->faker->randomElement([
                20,
                30,
                50,
                70,
                80,
            ]),
            'jenis_kriteria' => $this->faker->randomElement([
                'Cost',
                'Benefit',
            ]),
        ];
    }
}
