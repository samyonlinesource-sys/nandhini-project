<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\GeoController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/profile',[UserController::class,'profile']);
    Route::post('/logout',[UserController::class,'logout']);
    Route::post('/checksession', [UserController::class , 'checksession']);

});
Route::post('/store', [SettingsController::class, 'store']);
Route::post('/view', [SettingsController::class, 'settingsview']);
Route::post('/update', [SettingsController::class, 'update']);

Route::post('/laravel/smtp',[SettingsController::class, 'test_mail']);

Route::get('/sendotp',[UserController::class, 'sendotp']);
Route::middleware(['auth:api','nandhini'])->prefix('admin')->name('admin')->group(function () {
   Route::get('/profile',[UserController::class,'profile']);

     Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::post('/dashboard/show', [DashboardController::class, 'show']);
     Route::get('/profile',[UserController::class,'profile']);
        //BrandController CRUD
   Route::get('/brand',[BrandController::class,'index']);
   Route::post('/brand/create',[BrandController::class,'create']);
   Route::post('/brand/update',[BrandController::class,'update']);
   Route::post('/brand/delete',[BrandController::class,'delete']);
    Route::post('/brand/restore',[BrandController::class,'restore']);
    Route::post('/brand/show_deleted',[BrandController::class,'show_deleted_records']);
    Route::get('/category',[CategoryController::class,'index']);
     Route::post('/category/create',[CategoryController::class,'create']);
     Route::post('/category/update',[CategoryController::class,'update']);
     Route::post('/category/delete',[CategoryController::class,'delete']);
    Route::post('/category/restore',[CategoryController::class,'restore']);
    Route::post('/category/show_deleted',[CategoryController::class,'show_deleted_records']);


     //ProductController CRUD
    Route::get('/product',[ProductController::class,'index']);
    Route::post('/product/create',[ProductController::class,'create']);
    Route::post('/product/update',[ProductController::class,'update']);
    Route::post('/product/delete',[ProductController::class,'delete']);
    Route::post('/product/restore',[ProductController::class,'restore']);
    Route::post('/product/show_deleted',[ProductController::class,'show_deleted_records']);

//Purchase Controller
Route::get('/purchase',[PurchaseController::class,'index']);
Route::post('/purchase/status',[PurchaseController::class,'purchase_status']);
Route::post('/purchase/create',[PurchaseController::class,'create']);
Route::post('/purchase/update',[PurchaseController::class,'update']);

Route::post('/purchase/delete',[PurchaseController::class,'delete']);
Route::post('/purchase/restore',[PurchaseController::class,'restore']);
Route::post('/purchase/show_deleted',[ProductController::class,'show_deleted_records']);


Route::post('/stripe/payment',[StripeController::class,'payment']);
Route::post('/stripe/payment/success',[StripeController::class,'paymentsuccess']);
Route::post('/stripe/payment/fail',[StripeController::class,'paymentfail']);
Route::get('/stripe/payment/paymentdetail',[StripeController::class,'paymentdetail']);

Route::post('/stripe/payment/sales/',[StripeController::class,'paymentsales']);
Route::post('/stripe/payment/sales/success',[StripeController::class,'payment_success_sales']);

Route::get('/geolocation',[GeoController::class,'get']);

});




  