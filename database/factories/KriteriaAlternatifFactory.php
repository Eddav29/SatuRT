<?php

namespace Database\Factories;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaAlternatif>
 */
class KriteriaAlternatifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kriteria_id' => Kriteria::pluck('kriteria_id')->random(),
            'alternatif_id' => Alternatif::pluck('alternatif_id')->random(),
            'nilai' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
