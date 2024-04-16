<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            Penduduk::factory()->create([
                'user_id' => $user->user_id,
            ]);
        });
        Penduduk::factory()
            ->count(80)
            ->create();
    }
}
