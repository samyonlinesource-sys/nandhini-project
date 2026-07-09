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
        $settings = BrandModel::find($request->id);

        if (!$settings) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $request->validate([
            'brand_code' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $settings->update([
            'brand_code' => $request->brand_code,
            'brand_name' => $request->brand_name,
            'status'=>$request->status
            // 'maintenance_mode' => $request->maintenance_mode,
        ]);

        return response()->json(['message' => 'Brand updated successfully', 'settings' => $settings], 200);
    }
    
public function delete(Request $request)
{
    $Brand = BrandModel::find($request->id);

    if (!$Brand) {
        return response()->json([
            'status' => false,
            'message' => 'Brand not found'
        ], 404);
    }
    $Brand->delete();

    return response()->json([
        'status' => true,
        'message' => 'Brand deleted successfully'
    ], 200);
}

public function restore(Request $request)
{
    $Brand = BrandModel::withTrashed()->find($request->id);

    if (!$Brand) {
        return response()->json([
            'status' => false,
            'message' => 'Brand not found'
        ], 404);
    }

    $Brand->restore();

    return response()->json([
        'status' => true,
        'message' => 'Brand restored successfully'
    ], 200);
}

public function show_deleted_records()
{
    $Brand = BrandModel::onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'message' => 'Deleted Brand records retrieved successfully',
        'data' => $Brand
    ], 200);
}

}