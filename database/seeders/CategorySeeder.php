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
        $json = File::get("public\Category.json");
        $category= json_decode($json);
        foreach ($category  as $key => $value) {

            Category::create([
                "category_name" => $value->category_name
            ]);

        }
    }
}
