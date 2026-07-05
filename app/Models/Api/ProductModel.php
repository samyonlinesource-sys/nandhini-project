<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\CategoryModel;
use App\Models\Api\BrandModel;
class ProductModel extends Model
{
    //
    protected $table = 'product';
    protected $fillable =['category_id','brand_id','user_id','user_name',
    'product_code','product_name','product_image','description','purchase_price','sales_price','MRP',
    'quantity','alert_quantity','expiry'
    ];

     public function brand(){
        return $this->belongsTo(BrandModel::class);
    }
      public function category(){
        return $this->belongsTo(CategoryModel::class);
    }
}