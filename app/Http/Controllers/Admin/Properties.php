<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Sub_property;

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




    public function createProperty(Request $request){
        $data = $request->except('_token');

        if ($data['id'] == null) {
            Property::create($data);
        }else{
            Property::where('id',$data['id'])->update($data);
        }
        session()->flash('success','Done');
        return back();
    }



    ////sub property
    public function sub_propertiesInfo($propId){
       $data['properties'] = Sub_property::where('prop_id',$propId)->get();
       return view('Admin/Properties/sub_propertiesInfo',$data);
    }




    public function sub_viewCreateProperty($id=false){
        $data['property'] = false;
        if ($id != false){
            $data['property'] = Sub_property::find($id);
        }
        return view('Admin/Properties/sub_viewCreateProperty',$data);
    }






    public function sub_createProperty($id){
        if ($data['id'] == null) {
            Sub_property::create($data);
        }else{
            Sub_property::where('id',$data['id'])->update($data);
        }
        session()->flash('success','Done');
        return back();
    }








}
