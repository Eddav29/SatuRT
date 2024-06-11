<?php

namespace Database\Factories;

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
            // 'pengajuan_id' => Pengajuan::pluck('pengajuan_id')->unique()->random(),
            // 'jenis_surat' => $this->faker->randomElement([
            //     'Surat Pengantar KTP',
            //     'Surat Pengantar Kartu keluarga',
            //     'Surat Pengantar Akta Kelahiran',
            //     'Surat Pengantar Akta Kematian',
            //     'Surat Pengantar SKCK',
            //     'Surat Pengantar Nikah',
            //     'Lainnya',
            // ]),
            // 'pemohon' => Penduduk::pluck('penduduk_id')->random(),
        ];
    }
}
