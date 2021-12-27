<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class Auth_user_api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('api')->check()) {
            return $next($request);
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
            if(!empty($user)){
                //$data['status'] = false;
                //$data['message'] = "plz login";
                //return response($data);
                return $next($request);
            }else{
                User::create(['deviceId'=>$request->header('device-id')]);
            }
            return $next($request);
        }
    }
}
