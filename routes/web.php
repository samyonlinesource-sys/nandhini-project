<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;



Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/brand-ajax', function () {
//     return view('admin/brand_ajax');
// });
// Route::get('/admin/dashboard', function () {
//     return view('admin/dashboard');
// })->name('dashboard');

Route::get('/admin/product_list', function () {
    return view('admin/product_list');
});

Route::get('/admin/category_list', function () {
    return view('admin/category_list');
});

Route::get('/admin/brand_list', function () {
    return view('admin/brand_list');
});


Route::get('/admin/purchase_list', function () {
    return view('admin/purchase_list');
});

Route::get('/admin/sales_list', function () {
    return view('admin/sales_list');
});

Route::get('/admin/general_settings', function () {
    return view('admin/general_settings');
});

// login 
Route::get('/admin',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.submit');




Route::get('/laravel/smtp', function(){
   Mail::raw('Test SMTP',function($message){
      $message->to('059nambinandhini@gmail.com')->subject('Testing Mail');
   });
   return 'Laravel SMTP mail get successfully';
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function (){

Route::post('/logout',[LoginController::class,'logout'])->name('logout');

     Route::get('/settings/index',[SettingsController::class,'index'] )->name('settings');
      Route::get('/settings/edit',[SettingsController::class,'edit'] )->name('system.settings');
      Route::get('/settings/company_settings',[SettingsController::class,'company_settings'] )->name('company.settings');
        Route::post('/settings/update',[SettingsController::class,'update'] )->name('settings.update');

     Route::get('/product/index',[ProductController::class,'index'] )->name('product');
     Route::get('/product/create',[ProductController::class,'index'] )->name('product');

     Route::get('/dashboard',[DashboardController::class,'index'] )->name('dashboard');

     Route::resource('brands',BrandController::class);
     Route::get('brands-data',[BrandController::class,'show_data'])->name('brands.data');

      
});