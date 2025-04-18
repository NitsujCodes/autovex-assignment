<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StorageFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::factory(10)->create();
        $this->seed_imageables($products);
    }

    public static function seed_imageables(Collection $products) : void
    {
        $storageFiles = StorageFile::all();
        if ($storageFiles->isNotEmpty()) {
            // Seed imageables table if we have storage files
            $storageFilesChunks = $storageFiles->chunk(3);
            foreach ($products as $product) {
                $productImages = $storageFilesChunks->pop();
                $sortOrder = 0;
                foreach ($productImages as $image) {
                    $product->images()->attach($image, [
                        'order' => $sortOrder,
                    ]);
                    $sortOrder++;
                }
            }
        }
    }
}
