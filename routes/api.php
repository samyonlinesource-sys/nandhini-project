<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoryController;


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
});


});

  