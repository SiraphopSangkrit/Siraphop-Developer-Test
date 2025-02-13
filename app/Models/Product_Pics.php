<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product_Pics extends Model
{
    use HasFactory;
    protected $table = 'products_pic';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Products::class,'product_id','product_id');
    }
}
