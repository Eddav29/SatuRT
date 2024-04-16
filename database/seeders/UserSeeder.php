<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'testrt',
            'email' => 'testrtr@example.com',
        ]);

        User::factory()->create([
            'username' => 'testpenduduk',
            'email' => 'testpenduduk@example.com',
        ]);

        User::factory(20)->create();
    }
}
