<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('main');
});

Route::get('/new-products', function () {
    return Inertia::render('NewProduct');
});

Route::get('/product-details',[ProductsController::class, 'ProductDetails'])->name('product-details');



Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products',[AdminController::class,'ProductPage'])->name('admin.products');
    Route::get('/admin/brands',[AdminController::class,'BrandPage'])->name('admin.brands');
    Route::get('/admin/categories',[AdminController::class,'CategoryPage'])->name('admin.categories');

    Route::post('/admin/products/create',[ProductsController::class,'CreateProducts'])->name('admin.products.create');
    Route::put('/admin/products/update/{id}',[ProductsController::class,'UpdateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/delete/{id}',[ProductsController::class,'DeleteProduct'])->name('admin.products.delete');

    Route::post('/admin/products/{id}/addPics', [ProductsController::class, 'addProductPictures'])->name('admin.products.addPic');
    Route::delete('/admin/products/delete/image/{id}', [ProductsController::class, 'deleteProductPictures'])->name('admin.products.deletePic');

    Route::delete('/admin/desc/delete/{id}', [ProductsController::class, 'destroyDesc'])->name('admin.desc.delete');

    Route::post('/admin/categories/create',[CategoryController::class,'CreateCategory'])->name('admin.category.create');
    Route::put('/admin/categories/update/{id}',[CategoryController::class,'UpdateCategory'])->name('admin.category.update');
    Route::delete('/admin/categories/delete/{id}',[CategoryController::class,'DeleteCategory'])->name('admin.category.delete');

    Route::post('/admin/brands/create',[BrandController::class,'CreateBrands'])->name('admin.brand.create');
    Route::put('/admin/brands/update/{id}',[BrandController::class,'UpdateBrands'])->name('admin.brand.update');
    Route::delete('/admin/brands/delete/{id}',[BrandController::class,'DeleteBrands'])->name('admin.brand.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
