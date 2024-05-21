<?php

namespace Database\Seeders;

use App\Models\Keuangan;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the first user with the role 'Ketua RT' and get the associated penduduk_id
        $user = User::with('penduduk')
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'Ketua RT');
            })
            ->first();

        if ($user && $user->penduduk) {
            $penduduk_id = $user->penduduk->penduduk_id;

            $data = [
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 20000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 25000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 100000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 200000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 350000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'penduduk_id' => $penduduk_id,
                    'total_keuangan' => 300000,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($data as $item) {
                Keuangan::create($item);
            }
        }
    }
}
