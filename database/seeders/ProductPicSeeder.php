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

        $products = Products::all();


        $sourcePath = public_path('seed_images');


        Storage::disk('public')->makeDirectory('products_image');

        foreach ($products as $product) {

            $images = File::glob($sourcePath . "/product{$product->product_id}_*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

            foreach ($images as $imagePath) {

                $image = new UploadedFile(
                    $imagePath,
                    basename($imagePath),
                    File::mimeType($imagePath),
                    null,
                    true
                );

                $picture_path = $image->store('products_image', 'public');


                Product_Pics::create([
                    'product_id' => $product->product_id,
                    'img_url' => $picture_path
                ]);
            }
        }
    }
}
