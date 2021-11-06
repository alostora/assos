<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class Properties extends Controller
{
    

    public function propertiesInfo(){
        $data['properties'] = Property::get();
        return view('Admin/Properties/propertiesInfo',$data);
    }




    public function viewCreateProperty($id=false){
        $data['property'] = false;
        if ($id != false){
            $data['property'] = Property::find($id);
        }
        return view('Admin/Properties/viewCreateProperty',$data);
    }




}
