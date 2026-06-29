<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Api\SettingsModel;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = UserModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $token=$user->createToken('API Token')->accessToken;
        //   $token = method_exists($user, 'createToken') ? $user->createToken('auth_token')->accessToken : null;

        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token'=>$token],201);
    }
    public function login(Request $request){

        $data=Validator::make($request->all(),[
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if($data->fails()){
               return response()->json(['status'=>false ,'message' => 'validation error'],422);
        }

        $user= UserModel::where('username',$request->username)->first();
        
        if(!$user || !Hash::check($request->password,$user->password)){
              return response()->json(['status'=>false ,'message' => 'Invalid Credentials'],401);
        }

         $token=$user->createToken('API Token')->accessToken;
           return response()->json(['message' => 'User Login successfully', 'user' => $user, 'token'=>$token],200);
    }
    public function profile(Request $request){
           return response()->json(['message' => 'User Profile', 'user' => $request->user()],200);
        
    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
       return response()->json(['message' => 'Logout Successful'],200);
    }

    public function checksession(Request $request){
        $user = auth()->user();
        if(!$user){
            return response()->json(['message' => 'Invalid Login or Session Expired', 'is_logged_in' => false, 'user_exists'=>false],401);
        }
        $user_data =UserModel::find($user->id);
        if(!$user_data){
            return response()->json(['message' => 'User data does not exists' , 'is_logged_in' => false, 'user_exists'=>false],404);
        }
        
        if($user_data->is_blocked || $user_data->status == 'inactive'){
            return response()->json(['message' => 'User data does not exists' , 'is_logged_in' => false, 'user_exists'=>false],404);
        }

        $settings=SettingsModel::first();
          if($settings->app_mode == 'active'|| $settings-> maintenance_mode == 'active'){
            return response()->json(['message' => 'App is under maintence' , 'is_logged_in' => false, 'user_exists'=>true , 'maintenance_mode' => true],503);
        }

       return response()->json(['message'=> 'Session valid. User logged in', 'is_logged_in' =>true, 'user_exists'=>'true', 'user_blocked'=>false, 'user_data' =>[$user_data], 'settings' =>$settings],200);
    }




}