<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Product_Desc;
use App\Models\Product_Pics;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{

    public function ProductDetails()
    {
        return Inertia::render('ProductDetail');
    }

    public function CreateProducts(Request $request)
    {


        $request->validate(
            [
                'product_name' => 'required|unique:products',
                'price' => 'required|numeric',
                'product_description' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_model' => 'required',

            ],
            [
                'product_name.required' => 'กรณาใส่ชื่อประเภทสินค้า',
                'product_name.unique' => 'ชื่อสินค้าซ้ำ',
                'price.required' => 'กรุณาใส่ราคาสินค้า',
                'price.numeric' => 'ราคาสินค้าจะต้องเป็นตัวเลข',
                'product_description.required' => 'กรุณาใส่รายละเอียดสินค้า',
                'category_id.required' => 'กรุณาเลือกประเภทสินค้า',
                'brand_id.required' => 'กรุณาเลือกแบรนด์สินค้า',
                'product_model.required' => 'กรุณาใส่รุ่นสินค้า',

            ]
        );


        $product = new Products;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->product_description = $request->product_description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->product_model = $request->product_model;
        $product->save();



        $product_desc = $request->desc;
        foreach ($product_desc as $desc) {
            $pro_desc = new Product_Desc;
            $pro_desc->product_id = $product->product_id;
            $pro_desc->title = $desc['title'];
            $pro_desc->description = $desc['description'];
            $pro_desc->save();
        }



        return redirect()->back();
    }
    public function UpdateProduct($id, Request $request)
    {
        $request->validate(
            [
                'product_name' => 'required|unique:products',
                'price' => 'required|numeric',
                'product_description' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_model' => 'required'
            ],
            [
                'product_name.required' => 'กรณาใส่ชื่อประเภทสินค้า',
                'product_name.unique' => 'ชื่อสินค้าซ้ำ',
                'price.required' => 'กรุณาใส่ราคาสินค้า',
                'price.numeric' => 'ราคาสินค้าจะต้องเป็นตัวเลข',
                'product_description.required' => 'กรุณาใส่รายละเอียดสินค้า',
                'category_id.required' => 'กรุณาเลือกประเภทสินค้า',
                'brand_id.required' => 'กรุณาเลือกแบรนด์สินค้า',
                'product_model.required' => 'กรุณาใส่รุ่นสินค้า'
            ]
        );

        $product = Products::find($id);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->product_description = $request->product_description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->product_model = $request->product_model;
        $product->save();

        $product_desc = $request->desc;

        foreach ($product_desc as $desc) {
            if (isset($desc['id'])) {

                $pro_desc = Product_Desc::find($desc['id']);
                $pro_desc->title = $desc['title'];
                $pro_desc->description = $desc['description'];
                $pro_desc->save();
            } else {
                $pro_desc = new Product_Desc;
                $pro_desc->product_id = $product->product_id;
                $pro_desc->title = $desc['title'];
                $pro_desc->description = $desc['description'];
                $pro_desc->save();
            }
        }

        return redirect()->back();
    }

    public function DeleteProduct($id)
    {
        Products::destroy($id);

        return redirect()->back();
    }

    public function destroyDesc($id)
    {
        $desc = Product_Desc::findOrFail($id);
        $desc->delete();

        return redirect()->back();
    }

    public function addProductPictures(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Validate each image
        ], [
            'image.required' => 'กรุณาใส่รูปสินค้า.',
        ]);


        $product_id = $request->product_id;

        $images = $request->file('image');
        $product_pic = new Product_Pics;
        $product_pic->product_id = $product_id;
        $picture_path = $images->store('products_image', 'public');
        $product_pic->img_url = $picture_path;
        $product_pic->save();



        return redirect()->back();
    }

    public function deleteProductPictures(Request $request, $id)
    {
        $picture = Product_Pics::find($id);
        if ($picture) {
            Storage::disk('public')->delete($picture->img_url);
            $picture->delete();
        }
        return redirect()->back();
    }
}
