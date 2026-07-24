<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\BrandModel;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index(){
        return view ('admin.brand_ajax');
    }
    public function show_data(){
        $brand=BrandModel::latest()->get();
        return response()->json($brand);
    }
    public function store(Request $request){
        $request->validate([
            'brand_code'=>'required|string|unique:brands,brand_code',
            'brand_name'=>'required|string',
            'description'=>'required|string',
            'status'=> 'required|in:active,inactive',
            'inapp_view'=>'required|in:0,1',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();

        $brand = BrandModel::create($data);

        return  response()->json([
            'success' =>true,
            'message' => 'Brand Created Success',
            'data'=>$brand
        ]);
    }
    public function show($id){
         $brand=BrandModel::findOrFail($id);
         return response()->json($brand);
    }

     public function update(Request $request, $id){
        $request->validate([
            'brand_code'=>'required|string|unique:brands,brand_code,'.$id,
            'brand_name'=>'required|string',
            'description'=>'required|string',
            'status'=> 'required|in:active,inactive',
            'inapp_view'=>'required|in:0,1',
        ]);
        $brand = BrandModel::findOrFail($id);
        $brand->update($request->all());
        return  response()->json([
            'success' =>true,
            'message' => 'Brand Updated Success',
            'data'=>$brand
        ]);
    }

    public function destroy($id){

        $brand = BrandModel::find($id);
        $brand->delete();

         return  response()->json([
            'success' =>true,
            'message' => 'Brand Deleted Success',
        ]);
    }
}