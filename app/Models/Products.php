<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Product_Desc;
use App\Models\Product_Pics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
    protected $primaryKey='product_id';

    public function brands(){
        return $this->belongsTo(Brands::class,'brand_id','brand_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','category_id');
    }
    public function product_desc(){
        return $this->hasMany(Product_Desc::class,'product_id');
    }
    public function product_pics(){
        return $this->hasMany(Product_Pics::class,'product_id');
    }
}
