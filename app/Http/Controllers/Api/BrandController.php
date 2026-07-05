<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\BrandModel;

class BrandController extends Controller
{
     public function index()
     {
        // $Brand = BrandModel::all();
        $Brand = BrandModel::where('status','active')->get();


        if($Brand->isEmpty()){
             return response()->json([
            'status' => false,
            'meassage'=>'Brand details not found',
        ], 404);
        }

        return response()->json([
            'status' => true,
             'meassage'=>'Brand list',
            'data' => $Brand
        ], 200);
    }

    public function create(Request $request){
        $request->validate([
          'brand_code'=>'required|string',
          'brand_name'=>'required|string',
        //   'status' => 'active'
        ]);

        $data=$request->all();

        $brand=BrandModel::create($data);

         return response()->json([
            'status' => true,
             'meassage'=>'Brand Created Successfully',
            'data' => $brand
        ], 200);
    }


    public function update(Request $request)
{
     $Brands = BrandModel::find($request->id);

        if (!$Brands) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $request->validate([
            'brand_code' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
 
    // Update all request fields except id
    $Brands->update($request->except('id'));

    return response()->json([
        'status'  => true,
        'message' => 'Brand Updated Successfully',
        'data'    => $Brands->fresh()
    ], 200);
}
   
    public function delete(Request $request)
    {
        $Brand = BrandModel::findOrFail($request->id);
        if($Brand->status == 'active'){
            return response()->json(['message' => 'Active Brand cannot be deleted'], 404);
        }

        if (!$Brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $Brand->delete();
           
        return response()->json(['message' => 'Brand deleted successfully', ], 200);
    }

    public function restore(Request $request)
    {
        $Brand = BrandModel::withTrashed()->findOrFail($request->id);

        if (!$Brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $Brand->restore();
           
        return response()->json(['message' => 'Brand restore successfully', ], 200);
    }


    public function show_deleted_records(Request $request)
    {
        $Brand = BrandModel::onlyTrashed()->get();

        if (!$Brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

       // $Brand->delete();
           
        return response()->json(['message' => 'Deleted Brand records retrieved successfully','data'=>$Brand ], 200);
    }


}