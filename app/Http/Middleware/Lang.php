<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lang
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
        if(!empty(session()->get('locale'))) {
            \App::setLocale(session()->get('locale'));
        }else{
            \App::setLocale('ar');
        }

        return $next($request);
    }
}
