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
}