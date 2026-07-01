<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if user logged in
        if(!auth()->check()){
            return response()->json(['message' => 'Unauthorized', ],401);
        }

        $user =auth()->user();

          //check if user status
        if($user->status == 'inactive'){
            return response()->json(['message' => 'Your account is blocked', ],403);
        }

           //check if user level
        if($user->user_level !=1){
            return response()->json(['message' => 'You are not authorized', ],401);
        }
        return $next($request);

    }
}