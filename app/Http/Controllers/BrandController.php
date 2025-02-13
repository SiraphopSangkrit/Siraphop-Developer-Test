<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;

class BrandController extends Controller
{
    public function CreateBrands(Request $request)
    {
        $request->validate(
            [
                'brand_name' => 'required|unique:brands'
            ],
            [
                'brand_name.required' => 'กรณาใส่ชื่อแบรนด์สินค้า',
                'brand_name.unique' => 'แบรนด์สินค้าซ้ำ'
            ]
        );

        Brands::create($request->all());

        return redirect()->back();
    }

    public function UpdateBrands($id, Request $request){
        $request->validate(
            [
                'brand_name' => 'required|unique:brands'
            ],
            [
                'brand_name.required' => 'กรณาใส่ชื่อแบรนด์สินค้า',
                'brand_name.unique' => 'แบรนด์สินค้าซ้ำ'
            ]
        );

        $brand = Brands::find($id);
        $brand->brand_name = $request->brand_name;
        $brand->save();

        return redirect()->back();
    }
    public function DeleteBrands($id)
    {
        Brands::find($id)->delete();
        return redirect()->back();
    }
}
