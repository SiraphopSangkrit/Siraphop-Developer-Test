<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $guarded = [];
    protected $primaryKey='category_id';

    public function products(){
        return $this->hasMany(Products::class,'product_id');
    }
}
