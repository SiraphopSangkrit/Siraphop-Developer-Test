<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product_Pics;
use App\Models\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ProductPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products
        $products = Products::all();

        // Source path where your seed images are located
        $sourcePath = public_path('seed_images');

        // Destination path in public folder
        $destinationPath = public_path('products_image');

        // Create destination directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        foreach ($products as $product) {
            // Get all images for this product
            $images = File::glob($sourcePath . "/product{$product->product_id}_*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

            foreach ($images as $imagePath) {
                // Generate new filename
                $filename = 'product' . $product->product_id . '_' . uniqid() . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

                // Copy file to public folder
                File::copy($imagePath, $destinationPath . '/' . $filename);

                // Create database record
                Product_Pics::create([
                    'product_id' => $product->product_id,
                    'img_url' => 'products_image/' . $filename
                ]);
            }
        }
    }
}
