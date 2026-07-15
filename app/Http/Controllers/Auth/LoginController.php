<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(){
        return view('admin.index');
    }
 public function login(Request $request){

        $credentials=Validator::make($request->all(),[
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

       $level_check = UserModel::where('username', $request['username'])
    ->whereIn('user_level',[1,2])
    ->first();

if (!$level_check) {
    throw ValidationException::withMessages([
        'username' => 'Access denied or username not valid. Admin-level users only can login.',
    ]);
}

// Hash Check
if (!Hash::check($request->password, $level_check->password)) {
    return back()->withInput()->withErrors([
        'password' => 'Invalid password.',
    ]);
}
 $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')->with('success', 'Welcome Nandhini');
}

return back()->withInput()->withErrors([
    'username' => 'Credential error',
]);
    
}
public function logout(Request $request){
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();  /// csrf token anjd networking

    return redirect()->route('login');


}
}