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
       $settings->update($request->except('id'));
    return back()->withInput()->withErrors(
    'Success','Updated Sucessfully',
);
    
    }
}
