<?php

namespace Database\Factories;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persuratan>
 */
class PersuratanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pengajuan_id' => Pengajuan::pluck('pengajuan_id')->random(),
            'jenis_surat' => $this->faker->randomElement([
                'Surat Keterangan Domisili',
                'Surat Keterangan Tidak Mampu',
                'Surat Keterangan Usaha',
                'Surat Keterangan Lahir',
                'Surat Keterangan Kematian',
                'Surat Keterangan Nikah',
                'Kartu Tanda Penduduk',
            ]),
            'nomor_surat' => $this->faker->word(),
            'dokumen_url' => $this->faker->word(),
        ];
    }
}
