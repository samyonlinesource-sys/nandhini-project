<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SettingsController;

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
