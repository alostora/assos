<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\Category;
use Auth;
use Hash;
use \Carbon\Carbon;

class Admins extends Controller
{
    

    public function login(){
        return view('Admin/login');
    }





    public function doLogin(Request $request){
        //return [phpinfo()];
        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('admin/');
        }else{
            return redirect('admin/login');
        }

    }




    public function dashboard(){
        $data['admins']= count(Admin::get(['id']));
        $data['users']= count(User::where('name','!=','guest')->get(['id']));
        $data['categories']= count(Category::get(['id']));
        
        return view('Admin/dashboard',$data);
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
            $request->session()->flash('success','admen has been edited successfully');

        }else{

            Admin::create($data);
            $request->session()->flash('success','admen has been created successfully');
        }
        
        return redirect('admin/adminInfo');
    }






    public function deleteAdmin(Request $request,$id=false){
        Admin::where('id',$id)->delete();
        $request->session()->flash('warning','admin has been deleted successfully');
        return redirect('admin/adminInfo');
    }





    public function logOut(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }

}
