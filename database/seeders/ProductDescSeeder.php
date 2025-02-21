<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product_Desc;
use Illuminate\Support\Facades\File;

class ProductDescSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/productsDesc.json');

        // Create directory if it doesn't exist
        if (!File::exists(dirname($jsonPath))) {
            File::makeDirectory(dirname($jsonPath), 0755, true);
        }

        if (!File::exists($jsonPath)) {
            throw new \Exception("productsDesc.json not found at: {$jsonPath}");
        }

        $json = File::get($jsonPath);
        $productsDesc= json_decode($json);

        foreach ($productsDesc as $productDesc) {
            Product_Desc::create([
                "product_id" => $productDesc->product_id,
               "title"=>$productDesc->title,
               "description"=>$productDesc->description,

            ]);
        }
    }
}
