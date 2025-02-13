<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_Desc extends Model
{
    use HasFactory;
    protected $table = 'products_desc_section';
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','product_id');
    }
}
