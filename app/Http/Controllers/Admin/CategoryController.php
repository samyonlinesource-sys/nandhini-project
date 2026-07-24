<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\BrandModel;
use App\Models\Api\CategoryModel;


class CategoryController extends Controller
{
   public function view(){
          $user=auth()->user();
          $user_role=$user->user_level;
          $user_id= $user->id;
        //   $category =CategoryModel::with('brand')->where('user_id',$user_id)->get();
        if($user->user_level == 1){
          $category =CategoryModel::with('brand')->get();
          }
         if($user->user_level == $user_role ){
             $category =CategoryModel::with('brand')->where('user_id',$user_id)->get();
         }
         return view('admin.category_list',compact('category'));
    }
    // public function index(){
      
    // }
}