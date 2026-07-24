<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class GeoController extends Controller
{
public function get(Request $request)
{
   $ip = $request->ip();
   
    if (in_array($ip, ['127.0.0.1', '::1']) || $this->isPrivateIp($ip)) {
        // $ip = '8.8.8.8'; // or use a service to get your real public IP
             $ip = trim(file_get_contents('https://api.ipify.org'));
    }
    $location = Location::get($ip);
    if (!$location) {
        return response()->json([
            'status' => false,
            'message' => 'Unable to detect location',
            'ip' => $ip,
        ]);
    }
    return response()->json([
        'status' => true,
        'ip' => $ip,
        'data' => [
            'ip' => $location
        ],
    ]);
}
private function isPrivateIp($ip){
    // return 
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
}

}