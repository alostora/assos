<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Users_auth extends Controller
{
    


    public function userCountery(Request $request){
        return $request->all();

    }





}
