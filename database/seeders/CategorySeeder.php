<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/Category.json');

        // Create directory if it doesn't exist
        if (!File::exists(dirname($jsonPath))) {
            File::makeDirectory(dirname($jsonPath), 0755, true);
        }

        if (!File::exists($jsonPath)) {
            throw new \Exception("Category.json not found at: {$jsonPath}");
        }

        $json = File::get($jsonPath);
        $categories = json_decode($json);

        foreach ($categories as $category) {
            Category::create([
                "category_name" => $category->category_name
            ]);
        }
    }
}
