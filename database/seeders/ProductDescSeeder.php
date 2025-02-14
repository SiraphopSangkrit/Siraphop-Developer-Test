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
        $json = File::get("public\productsDesc.json");
        $products= json_decode($json);
        foreach ($products  as $key => $value) {

            Product_Desc::create([
                "product_id" => $value->product_id,
               "title"=>$value->title,
               "description"=>$value->description,

            ]);

        }
    }
}
