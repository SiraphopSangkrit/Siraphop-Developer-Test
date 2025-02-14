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
        $json = File::get("public\products.json");
        $products= json_decode($json);
        foreach ($products  as $key => $value) {

            Products::create([
                "product_id" => $value->product_id,
                "category_id" => $value->category_id,
                "brand_id" => $value->brand_id,
                "product_model" => $value->product_model,
                "product_description" => $value->product_description,
                "price" => $value->price,
                "product_status" => '1'

            ]);

        }
    }
}
