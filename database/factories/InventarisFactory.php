<?php

namespace Database\Factories;

use App\Models\Inventaris;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventarisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'penduduk_id' => Penduduk::pluck('penduduk_id')->random(),
            'nama_inventaris' => $this->faker->name(),
            'merk' => $this->faker->company,
            'warna' => $this->faker->colorName,
            'jumlah' => $this->faker->numberBetween(1, 10),
            'kondisi' => $this->faker->randomElement(['Cukup', 'Baik', 'Baru', 'Cacat', 'Rusak']),
            'jenis' => $this->faker->randomElement(['Furnitur', 'Elektronik', 'ATK', 'Kendaraan', 'Perlengkapan', 'Lainnya']),
            'sumber' => $this->faker->randomElement(['Hibah', 'Beli', 'Donasi', 'Bantuan', 'Pinjaman', 'Lainnya']),
            'keterangan' => $this->faker->text,
            'foto_inventaris' => $this->faker->imageUrl(),
        ];
    }
}
