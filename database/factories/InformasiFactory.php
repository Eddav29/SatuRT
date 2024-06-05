<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Informasi>
 */
class InformasiFactory extends Factory
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
            'judul_informasi' => $this->faker->word(),
            'jenis_informasi' => $this->faker->randomElement([
                'Pengumuman',
                'Dokumentasi Kegiatan',
                'Dokumentasi Rapat',
                'Berita',
                'Artikel',
            ]),
            'isi_informasi' => $this->faker->word(),
            'excerpt' => $this->faker->word(),
            'thumbnail_url' => $this->faker->word(),
        ];
    }
}
