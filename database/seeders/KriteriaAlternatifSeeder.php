<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KriteriaAlternatif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaAlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            [
                'nama_kriteria' => 'Relevansi',
                'bobot' => 35,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'nama_kriteria' => 'Dampak Sosial',
                'bobot' => 20,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'nama_kriteria' => 'Jumlah Panitia',
                'bobot' => 15,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'nama_kriteria' => 'Biaya',
                'bobot' => 15,
                'jenis_kriteria' => 'Cost',
            ],
            [
                'nama_kriteria' => 'Kesulitan',
                'bobot' => 15,
                'jenis_kriteria' => 'Cost',
            ],
        ];
        foreach ($kriteria as $kriteria) {
            Kriteria::factory()
                ->count(1)
                ->create($kriteria);
        }

        $alternatif = [
            ['nama_alternatif' => 'HUT RI'],
            ['nama_alternatif' => 'Kerja Bakti'],
            ['nama_alternatif' => 'Bakti Sosial'],
            ['nama_alternatif' => 'Jalan Sehat'],
            ['nama_alternatif' => 'Pelatihan Masyarakat'],
            ['nama_alternatif' => 'Bersih Desa'],
            ['nama_alternatif' => 'Pagelaran Seni & Budaya'],
            ['nama_alternatif' => 'Persiapan Hari Besar Islam'],
            ['nama_alternatif' => 'Rekreasi Bersama'],
            ['nama_alternatif' => 'Bazar'],
        ];
        foreach ($alternatif as $alternatif) {
            Alternatif::factory()
                ->count(1)
                ->create($alternatif);
        }
        $tableData = [
            [5, 5, 4, 2, 3],
            [4, 4, 4, 5, 5],
            [4, 4, 4, 4, 3],
            [5, 5, 4, 2, 4],
            [3, 3, 3, 5, 1],
            [4, 5, 5, 3, 2],
            [3, 3, 4, 3, 2],
            [3, 4, 5, 3, 3],
            [3, 2, 5, 1, 3],
            [3, 2, 5, 1, 5]
        ];
        foreach (Kriteria::all() as $kriteria) {
            foreach (Alternatif::all() as $alternatif) {
                KriteriaAlternatif::factory()
                    ->count(1)
                    ->create([
                        'kriteria_id' => $kriteria->kriteria_id,
                        'alternatif_id' => $alternatif->alternatif_id,
                        'nilai' => $tableData[$alternatif->alternatif_id - 1][$kriteria->kriteria_id - 1],
                    ]);
            }
        }
    }
}
