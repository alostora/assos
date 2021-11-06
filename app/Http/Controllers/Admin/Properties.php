<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Properties extends Controller
{
    

    public function propertiesInfo(){
        return view('Admin/Properties/propertiesInfo');
    }




}
