<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Brands extends Model
{
    use HasFactory;
    protected $table ='brands';
    protected $guarded =[] ;
    protected $primaryKey='brand_id';
    public function products(){
        return $this->hasMany(Products::class,'product_id');
    }
}
