<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
    use SoftDeletes;
    protected $table ='sales';

    protected $fillable = ['sales_code','sales_date','sales_due','customer_id','payment_intent_id','payment_method',
    'user_id','payment_status','paid_amount','total','round_off','balance_amount'];

}