<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function CreateCategory(Request $request)
    {
        $request->validate(
            [
                'category_name' => 'required|unique:category'
            ],
            [
                'category_name.required' => 'กรณาใส่ชื่อประเภทสินค้า',
                'category_name.unique' => 'ประเภทสินค้าซ้ำ'
            ]
        );


        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->back();
    }

    public function UpdateCategory(Request $request, $id)
    {
        $request->validate(
            [
                'category_name' => 'required|unique:category'
            ],
            [
                'category_name.required' => 'กรณาใส่ชื่อประเภทสินค้า',
                'category_name.unique' => 'ประเภทสินค้าซ้ำ'
            ]
        );

        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->back();
    }
    public function DeleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back();
    }
}
