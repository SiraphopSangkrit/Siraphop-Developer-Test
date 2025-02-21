<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
use Illuminate\Support\Facades\File;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/products.json');

        // Create directory if it doesn't exist
        if (!File::exists(dirname($jsonPath))) {
            File::makeDirectory(dirname($jsonPath), 0755, true);
        }

        if (!File::exists($jsonPath)) {
            throw new \Exception("products.json not found at: {$jsonPath}");
        }

        $json = File::get($jsonPath);
        $products= json_decode($json);

        foreach ($products as $product) {
            Products::create([
                "product_id" => $product->product_id,
                "category_id" => $product->category_id,
                "brand_id" => $product->brand_id,
                "product_model" => $product->product_model,
                "product_description" => $product->product_description,
                "price" => $product->price,
                "product_status" => '1'

            ]);
        }
    }
}
