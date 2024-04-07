<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KartuKeluarga>
 */
class KartuKeluargaFactory extends Factory
{
    use HasFactory, SoftDeletes;
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
            'desa' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'kota' => $this->faker->city(),
        ];
    }
}
