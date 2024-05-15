<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FileStorage>
 */
class FileStorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_storage_id' => \App\Models\FileStorage::pluck('file_storage_id')->random(),
            'file_name' => $this->faker->word(),
            'file_extension' => $this->faker->word(),
            'file_type' => $this->faker->word(),
            'file_size' => $this->faker->word(),
            'file_url' => $this->faker->word(),
            'disk_name' => $this->faker->word(),
        ];
    }
}
