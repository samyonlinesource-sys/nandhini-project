<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\PurchaseModel;

class PurchaseController extends Controller
{
    public function index(){
        $purchase =PurchaseModel::where('status','active')->get();
        if($purchase->isEmpty()){
            return response()->json([
                'status'=>false, 'message'=>'Purchase not found'
            ],404);
        }
        return response()->json([
            'status'=>true, 'message'=>'Purchase data get successfully', 'data'=>$purchase
        ],200);
    }

    public function purchase_status(Request $request){
    
        $purchase =PurchaseModel::find($request->id);

        if(!$purchase){
            return response()->json([
                'status'=>false, 'message'=>'Purchase not found'
            ],404);
        }
        if($purchase->status =='active'){
           return response()->json([
            'status'=>true, 'message'=>'Given Purchase data active', 'data'=>$purchase
        ],200);
        }

    }

    public function create(Request $request){

       $request->validate([
        'purchase_code'=>'required',
        'amount' =>'required',
      
       ]);
      
       $data =$request->all();
        $data['user_id']=auth()->user()->id;
       $purchase=PurchaseModel::create($data);

      return response()->json([
            'status'=>true, 'message'=>'Purchase data Created Successfully', 'data'=>$purchase
        ],200);
        

    }

    public function update(Request $request){
        $purchase=PurchaseModel::find($request->id);
        if(!$purchase){
            return response()->json([
                'status'=>false, 'message'=>'Purchase not found'
            ],404);
        }

       $request->validate([
        'purchase_code'=>'required',
        'amount' =>'required',
       ]);
      
       $data=$request->except('id');
       $purchase->update($data);
      
      return response()->json([
            'status'=>true, 'message'=>'Purchase data Created Successfully', 'data'=>$purchase
        ],200);
        

    }


}
