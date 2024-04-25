<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keuangan>
 */
class KeuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penduduk_id' => Penduduk::pluck('penduduk_id')->random(),
            'total_keuangan' => $this->faker->numberBetween(100000, 1000000),
            'tanggal' => Carbon::createFromTimestamp(
                $this->faker->dateTimeBetween('-20 years', '-19 years')->getTimestamp()
            ),
            'created_at' => Carbon::createFromTimestamp(
                $this->faker->dateTimeBetween('-20 years', '-19 years')->getTimestamp()
            ),
            'updated_at' => Carbon::createFromTimestamp(
                $this->faker->dateTimeBetween('-20 years', '-19 years')->getTimestamp()
            ),
        ];
    }
}
