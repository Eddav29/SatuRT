<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengajuan>
 */
class PengajuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'penduduk_id' => Penduduk::pluck('penduduk_id')->random(),
            // 'status_id' => Status::pluck('status_id')->random(),
            // 'accepted_by' => Penduduk::pluck('penduduk_id')->random(),
            // 'keperluan' => $this->faker->sentence(),
            // 'keterangan' => $this->faker->paragraph(),
            // 'accepted_at' => $this->faker->date(),
        ];
    }
}
