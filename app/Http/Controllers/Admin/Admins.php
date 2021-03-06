<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Property;
use App\Models\Offer;
use App\Models\Ad;
use App\Models\Order_setting;
use App\Models\Item_back_reason;
use App\Models\Contact_message;
use Auth;
use Hash;
use \Carbon\Carbon;
use Lang;

class Admins extends Controller
{


    public function login(){
        return view('MainLayouts/login');
    }





    public function doLogin(Request $request){

        $validated = $request->validate([
          'email' => 'required|email|max:100',
          'password' => 'required|max:100',
        ]);


        if(Auth::guard('admin')->attempt($validated)){
            return redirect('admin');
        }else{
            session()->flash('warning','error informations');
            return redirect('admin/login');
        }

    }




    public function dashboard(){
        $data['admins']= Admin::count();
        $data['vendors']= Vendor::count();
        $data['categories']= Category::count();
        $data['properties']= Property::count();
        $data['offers']= Offer::count();
        $data['ads']= Ad::count();

        return view('MainLayouts/dashboard',$data);
    }





    public function adminInfo(){
        $admins= Admin::get();
        return view('Admin/Admin/adminInfo',compact('admins'));
    }



    public function viewCreateAdmin($id=false){
        $data['admin'] = "";
        if($id != false){
            $data['admin'] = Admin::find($id);
        }

        return view('Admin/Admin/viewCreateAdmin',$data);
    }




    public function createAdmin(Request $request){


        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:admins,email,'.$request->id.'|max:100',
            'password' => 'required|max:100',
            'confirmPassword' => 'same:password',
        ]);


        if($request->password != $request->confirmPassword){
            $request->session()->flash('warning','password does not matched');//error message
            return back();
        }

        $data = $request->except(['_token','confirmPassword']);

        if($request->password != null){
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }


        if($request->id != null){
            Admin::where('id',$request->id)->update($data);
            session()->flash('success',Lang::get('leftsidebar.Updated'));
        }else{
            Admin::create($data);
            session()->flash('success',Lang::get('leftsidebar.Created'));
        }

        return redirect('admin/adminInfo');
    }






    public function deleteAdmin(Request $request,$id=false){
        Admin::where('id',$id)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return redirect('admin/adminInfo');
    }





    public function contactUs(){
        $data['messages'] = Contact_message::get();
        return view('Admin/Admin/contactUs',$data);

    }





    public function logOut(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }







}
