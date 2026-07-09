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
    // public function update(Request $request){

            
    //         $Brand = BrandModel::findorFail($request->id);
            
    //         $request->validate([
    //                 'brand_code'=>'required|string',
    //                 'brand_name'=>'required|string',
                     
    //         ]);

    //         $Brand->update([
    //                 'brand_code'=>$request->brand_code,
    //                 'brand_name'=>$request->brand_name,
    //                 //   'status' => 'active'
    //         ]);
            

    //         return response()->json([
    //             'status' => true,
    //             'meassage'=>'Brand Updated Successfully',
    //             'data' => $Brand
    //         ], 200);
    // }

    public function delete(Request $request)
{
    $category = BrandModel::find($request->id);

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Brand not found'
        ], 404);
    }

    // Get the brand from the category
    $brand = BrandModel::where('id', $category->brand_id)
                ->where('status', 'active')
                ->first();

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    $category->delete();

    return response()->json([
        'status' => true,
        'message' => 'Brand deleted successfully'
    ], 200);
}
    public function restore(Request $request)
{
    $category = BrandModel::withTrashed()->find($request->id);

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ], 404);
    }

    $brand = BrandModel::where('id', $category->brand_id)
                ->where('status', 'active')
                ->first();

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    $category->restore();

    return response()->json([
        'status' => true,
        'message' => 'Category restored successfully'
    ], 200);
}


    public function show_deleted_records()
{
    $categories = BrandModel::onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'message' => 'Deleted Category records retrieved successfully',
        'data' => $categories
    ], 200);
}
}