<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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


}