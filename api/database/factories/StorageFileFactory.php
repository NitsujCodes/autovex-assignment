<?php

namespace Database\Factories;

use App\Models\StorageFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StorageFile>
 */
class StorageFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'relative_path' => fake()->url(),
            'mime_type' => fake()->mimeType(),
            'size' => fake()->randomFloat(2, 1, 1000),
            'disk' => fake()->randomElement(['public', 's3']),
            'uuid' => fake()->uuid(),
            'extension' => fake()->fileExtension(),
        ];
    }
}
