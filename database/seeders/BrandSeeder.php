<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brands;
use Illuminate\Support\Facades\File;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("public\Brand.json");
        $brands = json_decode($json);
        foreach ($brands  as $key => $value) {

            Brands::create([
                "brand_name" => $value->brand_name
            ]);

        }
    }
}
