<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Lang;
use Auth;

class Auth_delivery
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
        if(Auth::guard('delivery')->check()) {
            return $next($request);
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.plz_login');
            return response($data);
        }
    }
}
