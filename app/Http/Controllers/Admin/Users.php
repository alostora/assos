<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Users extends Controller
{
    

    public function userInfo(){
        $data['users'] = User::where('email','!=',null)->get();
        return view('Admin/Users/userInfo',$data); 
    }




}
