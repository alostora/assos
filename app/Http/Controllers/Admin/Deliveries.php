<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Hash;
use Lang;

class Deliveries extends Controller
{
    




    public function deliveryInfo(){
        $deliveries= Delivery::get();
        return view('Admin/Delivery/deliveryInfo',compact('deliveries'));
    }



    public function viewCreateDelivery($id=false){
        $data['delivery'] = "";
        if($id != false){
            $data['delivery'] = Delivery::find($id);
        }

        return view('Admin/Delivery/viewCreateDelivery',$data);
    }




    public function createDelivery(Request $request){


        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:deliveries,email,'.$request->id.'|max:100',
            'phone' => 'required|unique:deliveries,phone,'.$request->id.'|max:15',
            'country' => 'required|in:sa,kw',
            'password' => 'max:100',
            'confirmPassword' => 'same:password',
        ]);


        $data = $request->except(['_token','confirmPassword']);

        if($request->password != null){
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }


        if($request->id != null){
            Delivery::where('id',$request->id)->update($data);
            session()->flash('success',Lang::get('leftsidebar.Updated'));
        }else{
            Delivery::create($data);
            session()->flash('success',Lang::get('leftsidebar.Created'));
        }

        return redirect('admin/deliveryInfo');
    }






    public function deleteDelivery(Request $request,$id=false){
        Delivery::where('id',$id)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return redirect('admin/deliveryInfo');
    }









}
