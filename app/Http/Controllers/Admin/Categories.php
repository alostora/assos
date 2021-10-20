<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Categories extends Controller
{
        
    public function categoriesInfo(){
        return view('Admin/Categories/categoriesInfo');
    }





}
