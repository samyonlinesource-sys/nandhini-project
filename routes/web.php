<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/admin', function () {
    return view('admin/index');
});
Route::post('/login',[LoginController::class,'login'])->name('login.submit');