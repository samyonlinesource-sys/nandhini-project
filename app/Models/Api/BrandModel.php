<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandModel extends Model
{
    use SoftDeletes;
    protected $table='brands';
    protected $dates=['deleted_at'];

    protected $fillable=['brand_code','brand_name','brand_image','description','status','inapp_view',];
    
}