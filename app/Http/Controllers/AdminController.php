<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Products;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function BrandPage()
    {
        $brands = Brands::all();
        return Inertia::render('Admin/Brands',[
            'brands' => $brands,
        ]);
    }

    public function ProductPage()
    {
        $brands = Brands::all();
        $categories = Category::all();
        $products = Products::with('brands','category','product_desc','product_pics')->get();
       
        return Inertia::render('Admin/Products',[
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function CategoryPage()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Category',[
            'categories' => $categories,
        ]);
    }
}
