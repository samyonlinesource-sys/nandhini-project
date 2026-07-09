<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseModel extends Model
{
    use SoftDeletes;
    protected $table ='purchase';
    protected $fillable =[
        'purchase_code', 'purchase_date',  'payment_intent_id',
    'payment_method','purchase_description','amount','grant_total','payment_status','status','user_id'
    ];
}