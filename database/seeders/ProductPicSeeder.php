<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product_Pics;
use App\Models\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products
        $products = Products::all();

        // Source path where your seed images are stored
        $sourcePath = public_path('img');

        // Create storage directory if it doesn't exist
        Storage::disk('public')->makeDirectory('products_image');

        foreach ($products as $product) {
            // Get all images for this product
            $images = File::glob($sourcePath . "/product{$product->product_id}_*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

            foreach ($images as $imagePath) {

                $image = new UploadedFile(
                    $imagePath,
                    basename($imagePath),
                    File::mimeType($imagePath),
                    null,
                    true
                );

                // Store the image like in addProductPictures method
                $picture_path = $image->store('products_image', 'public');

                // Create the product picture record
                Product_Pics::create([
                    'product_id' => $product->product_id,
                    'img_url' => $picture_path
                ]);
            }
        }
    }
}
