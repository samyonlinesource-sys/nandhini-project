<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\UserModel;

class DashboardController extends Controller
{
    // Display all users
    public function index(Request $request)
    {
        // $users = UserModel::get();  eloquent
        $users =  "Select * from `user'";

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ], 200);
    }

    // Display a single user
    public function show(Request $request)
    {
        $user = UserModel::find($request->id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => $user
        ], 200);
    }
}