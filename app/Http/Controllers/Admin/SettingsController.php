<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\SettingsModel;
class SettingsController extends Controller
{
    public function index(){
      $settings=SettingsModel::latest()->get();
      return view('admin.general_settings',compact('settings'));
    }

    public function edit(){
      return view('admin.system_settings');
    }

      public function company_settings(){
         $settings=SettingsModel::latest()->get();
      return view('admin.company_settings',compact('settings'));
    }
    public function update(Request $request){
     $settings=SettingsModel::findOrFail($request->id);
     $images =['company_logo','company_icon','favicon'];
     foreach($images as $image){
      if($request->hasfile($image)){
        $request->validate([
          $image=> 'nullable',
        ]);
        $img =$request->file($image);
        $img_rename=time().'-'.$image.'-'.$img->getClientOriginalExtension();
        $img->move(public_path('upload/settings'),$img_rename);
        $settings->$image=$img_rename;
      }
     }
       $settings->fill($request->except('id','company_logo','company_icon','favicon'));
       $settings->save();

    return back()->withInput()->withErrors(
    'Success','Updated Sucessfully',
);
    
    }
}