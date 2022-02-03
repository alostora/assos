<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Lang;
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
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.plz_login');
            return response($data);
        }
    }
}
