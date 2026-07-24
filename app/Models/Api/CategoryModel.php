<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
     use SoftDeletes;
    protected $table ='categories';
    protected $fillable =[
        'category_code', 'category_name','category_image','description','inapp_view','status','brand_id','user_id'
    ];
    public function brand(){
        return $this->belongsTo(BrandModel::class,'brand_id','id');
    }
}