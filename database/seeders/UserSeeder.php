<?php

namespace Database\Seeders;

use App\Models\KartuKeluarga;
use App\Models\Role;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleRT = Role::where('role_name', 'Ketua RT')->first();
        $rolePenduduk = Role::where('role_name', 'Penduduk')->first();
        User::factory()->create([
            'username' => 'testrt',
            'email' => 'testrt@example.com',
            'role_id' => $roleRT->role_id,
            'password' => Hash::make('12312312'),
        ]);

        User::factory()->create([
            'username' => 'testpenduduk',
            'email' => 'testpenduduk@example.com',
            'role_id' => $rolePenduduk->role_id,
            'password' => Hash::make('12341234'),
        ]);
    }
}
