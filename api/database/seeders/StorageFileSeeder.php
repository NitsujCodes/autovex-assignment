<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StorageFile;
use Illuminate\Database\Seeder;

class StorageFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StorageFile::factory(50)->create();
    }
}
