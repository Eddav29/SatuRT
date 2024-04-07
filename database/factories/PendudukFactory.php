<?php

namespace Database\Factories;

use App\Models\KartuKeluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penduduk>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kartu_keluarga_id' => KartuKeluarga::pluck('kartu_keluarga_id')->random(),
            'user_id' => \App\Models\User::pluck('user_id')->random(),
            'nik' => $this->faker->unique()->numerify('################'),
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'pekerjaan' => $this->faker->jobTitle(),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'status_hubungan_dalam_keluarga' => $this->faker->randomElement(['Kepala Keluarga', 'Istri', 'Anak', 'Cucu', 'Ayah', 'Ibu', 'Saudara', 'Mertua', 'Menantu', 'Cucu Menantu', 'Cicit', 'Keluarga Lain']),
            'status_perkawinan' => $this->faker->randomElement(['Kawin', 'Belum Kawin', 'Cerai']),
            'pendidikan_terakhir' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'foto_ktp' => $this->faker->imageUrl(),
            'status_penduduk' => $this->faker->randomElement(['Domisili', 'Non Domisili']),
            'nomor_rt' => $this->faker->numberBetween(1, 99),
            'nomor_rw' => $this->faker->numberBetween(1, 99),
            'desa' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'kota' => $this->faker->city(),
        ];
    }
}
