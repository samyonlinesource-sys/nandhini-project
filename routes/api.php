<?php

use App\Http\Controllers\Api\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/profile',[UserController::class,'profile']);
    Route::post('/logout',[UserController::class,'logout']);

});