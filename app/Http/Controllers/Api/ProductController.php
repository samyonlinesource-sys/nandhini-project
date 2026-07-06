<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\ProductModel;
use App\Models\Api\BrandModel;
use App\Models\Api\CategoryModel;


class ProductController extends Controller
{
    //
    public function index(){
        $product = ProductModel::where('status','active')->get();
        if($product->isEmpty()){
            return response()->json(['status'=>false,'message'=>'Product Not Found'],404);
        }
         return response()->json(['status'=>true,'message'=>'Product Details','data'=>$product],200);
    }
    public function create (Request $request){
        $request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'user_id' => 'required',
            'user_name' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'purchase_price' => 'required',
            'sales_price' => 'required',
            'MRP' => 'required',
            'quantity' => 'required',
            'alert_quantity' => 'required',
            'expiry' => 'required',
        ]);

        
        $category =CategoryModel::where('status','active')->where('brand_id',$request->brand_id)->find($request->category_id);

       if(!$category || !$request->category_id || !$request->brand_id){
         return response()->json([
            'status'=>false, 'message'=>'Active Category not found'
         ],404);
       }

       $product=$request->all();
       $product_data = ProductModel::create($product);
        return response()->json([
            'status'=>true, 'message'=>'Product Create  Successfully','data'=>$product_data
         ],200);
       
    }
public function update(Request $request)
{
    // Find Product
    $product = ProductModel::find($request->id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    // Validate required fields
    $request->validate([
        'category_id'     => 'required',
        'brand_id'        => 'required',
        'user_id'         => 'required',
        'user_name'       => 'required',
        'product_name'    => 'required',
        'product_code'    => 'required',
        'purchase_price'  => 'required',
        'sales_price'     => 'required',
        'MRP'             => 'required',
        'quantity'        => 'required',
        'alert_quantity'  => 'required',
        'expiry'          => 'required',
    ]);

    // Check Active Brand
    $brand = BrandModel::where('status', 'active')
                ->find($request->brand_id);

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    // Check Active Category belongs to Brand
    $category = CategoryModel::where('status', 'active')
                    ->where('brand_id', $request->brand_id)
                    ->find($request->category_id);

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Active Category not found'
        ], 404);
    }

    // Update Product
    $product->update($request->except('id'));

    return response()->json([
        'status'  => true,
        'message' => 'Product Updated Successfully',
        'data'    => $product->fresh()
    ], 200);
}

public function delete(Request $request)
{
    $product = ProductModel::find($request->id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    // Check active brand
    $brand = BrandModel::where('id', $product->brand_id)
                ->where('status', 'active')
                ->first();

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    // Check active category
    $category = CategoryModel::where('id', $product->category_id)
                    ->where('status', 'active')
                    ->first();

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Active Category not found'
        ], 404);
    }

    $product->delete();

    return response()->json([
        'status' => true,
        'message' => 'Product deleted successfully'
    ], 200);
}

public function restore(Request $request)
{
    $product = ProductModel::withTrashed()->find($request->id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    // Check active brand
    $brand = BrandModel::where('id', $product->brand_id)
                ->where('status', 'active')
                ->first();

    if (!$brand) {
        return response()->json([
            'status' => false,
            'message' => 'Active Brand not found'
        ], 404);
    }

    // Check active category
    $category = CategoryModel::where('id', $product->category_id)
                    ->where('status', 'active')
                    ->first();

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Active Category not found'
        ], 404);
    }

    $product->restore();

    return response()->json([
        'status' => true,
        'message' => 'Product restored successfully'
    ], 200);
}

public function show_deleted_records()
{
    $products = ProductModel::onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'message' => 'Deleted Product records retrieved successfully',
        'data' => $products
    ], 200);
}
}