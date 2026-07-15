<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\ProductModel;
use App\Models\Api\BrandModel;
use App\Models\Api\CategoryModel;

class ProductController extends Controller
{
    //
    public function  index(){
        $product = ProductModel::with('category','brand')->latest()->get();
        return view('admin.product_list',compact('product'));
    }
    public function Details(Request $request ){
        $product = ProductModel::find($request->id);
        return view('admin.product_details',compact('product'));

    }
}