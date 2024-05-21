<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UMKM>
 */
class UMKMFactory extends Factory
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
            'nama_umkm' => $this->faker->word(),
            'jenis_umkm' => $this->faker->randomElement([
                'Makanan dan Minuman',
                'Pakaian',
                'Peralatan',
                'Jasa',
                'Lainnya'
            ]),
            'keterangan' => $this->faker->word(),
            'alamat' => $this->faker->word(),
            'nomor_telepon' => $this->faker->word(),
            'lokasi_url' => $this->faker->word(),
            'thumbnail_url' => $this->faker->word(),
            'status' => $this->faker->randomElement([
                'Aktif', 'Nonaktif'
            ]),
            'lisence_image_url' => $this->faker->word(),
        ];
    }
}
