<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\SalesModel;

class SalesController extends Controller
{
    public function index(){
        $sale=SalesModel::all();
        if($sale->isEmpty()){
            return response()->json([
                'status'=>false,
                'message'=>'Sales Details Not Found',
            ],404);
        }
         return response()->json([
                'status'=>true,
                'message'=>'Sales List',
                'data'=>$sale
            ],200);
    }

    public function create(Request $request){
        $request->validate(['sales_code' => 'required',
        'sales_date' => 'required',
        'sales_due' => 'required',
        'customer_id' => 'required',
        'user_id'=>'required',
        'payment_status'=>'required',
        'paid_amount'=>'required',
        'total'=>'required',
        'round_off' => 'required'
        ]);

        
        $data= $request->all();
        $data['user_id']=auth()->user()->id;
        $sales=SalesModel::create($data);

        return response()->json([
                'status'=>true,
                'message'=>'Sales List',
                'data'=>$sales
        ],200);
    }

    public function update(Request $request){
        $sales=SalesModel::find($request->id);
        if(!$sales){
            return response()->json([
                'status'=>false,
                'message'=>"Sales not found",
            ],404);
        }
        $request->validate([
             'sales_date' => 'required',
        'sales_due' => 'required',
        'customer_id' => 'required',
        'user_id'=>'required',
        'payment_status'=>'required',
        'paid_amount'=>'required',
        'total'=>'required',
        'round_off' => 'required'
        ]);

        $data = $request->except('id');
        $sales->update($data);
        
         return response()->json([
                'status'=>true,
                'message'=>"Sales Updated Successfully",
                'data'=>$sales
        ],200);
    }
        public function delete(Request $request)
        {
            $Sales = SalesModel::find($request->id);

            if (!$Sales) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sales not found'
                ], 404);
            }

            $Sales->delete();

            return response()->json([
                'status' => true,
                'message' => 'Sales deleted successfully'
            ], 200);
        }

        public function restore(Request $request)
        {
            $sales = SalesModel::withTrashed()->find($request->id);

            if (!$sales) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sales not found'
                ], 404);
            }

            $sales->restore();

            return response()->json([
                'status' => true,
                'message' => 'Sales Restored Successfully'
            ], 200);
        }

        public function show_deleted_records()
        {
            $sales = SalesModel::onlyTrashed()->get();

            return response()->json([
                'status' => true,
                'message' => 'Deleted sales records retrieved successfully',
                'data' => $sales
            ], 200);
        }
    
}