<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $table='brands';

    protected $fillable=['brand_code','brand_name','brand_image','description','status','inapp_view'];
    
}