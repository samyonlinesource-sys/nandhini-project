<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\BrandModel;
use App\Models\Api\CategoryModel;


class CategoryController extends Controller
{
    public function index(){
      $categories =CategoryModel::where('status','active')->get();
      if($categories->isEmpty()){
        return response()->json([
            'status' =>false,
            'message'=>'Category not found',
        ],404);
      }
      return response()->json(['status' =>true, 'message'=>'category data get successfully','data'=>$categories ], 200);

    }

    public function create(Request $request){
    
        $request->validate([
            'category_code'=>'required',
            'category_name'=>'required',
            'brand_id'=>'required'
        ]);
   

        $Brand =BrandModel::where('status','active')->find($request->brand_id);

       if(!$Brand || !$request->brand_id){
         return response()->json([
            'status'=>false, 'message'=>'Active Brand not found'
         ],404);
       }
     
       $data=$request->all();
       $category=CategoryModel::create($data);
       return response()->json([
            'status'=>true, 'message'=>'Category Created Successfully',
         'data'=>$category ],201);
    }



    // public function update(Request $request){
    //     $categories=CategoriesModel::find($request->id);
    //     if(!$categories){
    //         return response()->json(['status'=>false, 'message'=>'Category not found'],404);
    //     }
    //     $request->validate([
    //         'category_code'=>'required',
    //         'category_name'=>'required',
    //         'brand_id'=>'required' 
    //     ]);
   

    //     $Brand =BrandModel::where('status','active')->find($request->brand_id);

    //    if(!$Brand || !$request->brand_id){
    //      return response()->json([
    //         'status'=>false, 'message'=>'Active Brand not found'
    //      ],404);
    //    }
    // $categories->update([
    //         'category_code' => $request->category_code,
    //         'category_name' => $request->category_name,
    //         'brand_id' => $request->brand_id
    //         // 'maintenance_mode' => $request->maintenance_mode,
    //     ]);
    //    return response()->json([
    //         'status'=>true, 'message'=>'Category Updated Successfully',
    //      'data'=>$categories ],201);
    // }


    public function update(Request $request)
{
    // Find category
    $categories = CategoryModel::find($request->id);

    if (!$categories) {
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ], 404);
    }

    // Validate required fields
    $request->validate([
        'category_code' => 'required',
        'category_name' => 'required',
        'brand_id'      => 'required',
    ]);

    // Check active brand
    $brand = BrandModel::where('status', 'active')
                ->find($request->brand_id);

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    // Update all request fields except id
    $categories->update($request->except('id'));

    return response()->json([
        'status'  => true,
        'message' => 'Category Updated Successfully',
        'data'    => $categories->fresh()
    ], 200);
}
    
public function delete(Request $request)
{
    $category = CategoryModel::find($request->id);

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
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
        'message' => 'Category deleted successfully'
    ], 200);
}
    public function restore(Request $request)
{
    $category = CategoryModel::withTrashed()->find($request->id);

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
    $categories = CategoryModel::onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'message' => 'Deleted Category records retrieved successfully',
        'data' => $categories
    ], 200);
}


}
