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
        $jsonPath = database_path('seeders/data/Brand.json');

        // Create directory if it doesn't exist
        if (!File::exists(dirname($jsonPath))) {
            File::makeDirectory(dirname($jsonPath), 0755, true);
        }

        if (!File::exists($jsonPath)) {
            throw new \Exception("Brand.json not found at: {$jsonPath}");
        }

        $json = File::get($jsonPath);
        $brands= json_decode($json);

        foreach ($brands as $brand) {
            Brands::create([
                "brand_name" => $brand->brand_name
            ]);
        }
    }
}
