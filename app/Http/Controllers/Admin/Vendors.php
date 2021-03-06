<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Hash;
use File;
use Lang;


class Vendors extends Controller
{


    public function vendorsInfo(){
       $data['vendors'] = Vendor::get();
       return view('Admin/Vendors/vendorsInfo',$data);
    }




    
    public function viewCreateVendor($id=false){
        if(!empty($id)) {
            $data['vendor'] = Vendor::where('id',$id)->first();
        }else{
            $data = [];
        }
        return view('Admin/Vendors/viewCreateVendor',$data);
    }





    public function createVendor(Request $request){
        $validated = $request->validate([
          'vendor_name' => 'required|max:100',
          'phone' => 'required|unique:vendors,phone,'. $request->id .'|max:100',
          'email' => 'required|unique:vendors,email,'. $request->id .'|email|max:100',
          'password' => 'max:100',
          'confirm_password' => 'same:password',
          'address' => 'required|max:100',
          'vendor_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'vendor_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token','confirm_password');
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        if (empty($data['id'])) {
            //add
            $data['vendor_image'] = null;
            $data['vendor_logo'] = null;

            if ($request->hasFile('vendor_image')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                $vendor_image = $request->file('vendor_image');
                $data['vendor_image'] = rand(11111, 99999).'.'.$vendor_image->getClientOriginalExtension();
                $vendor_image->move($destinationPath, $data['vendor_image']);
            }

            if ($request->hasFile('vendor_logo')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                $vendor_logo = $request->file('vendor_logo');
                $data['vendor_logo'] = rand(11111, 99999).'.'.$vendor_logo->getClientOriginalExtension();
                $vendor_logo->move($destinationPath, $data['vendor_logo']);
            }
            Vendor::create($data);
            session()->flash('warning',Lang::get('leftsidebar.Created'));
        }else{
            //edit
            $vendor = Vendor::find($data['id']);
            $data['vendor_image'] = $vendor->vendor_image;

            if($request->hasFile('vendor_image')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                File::delete($destinationPath . $data['vendor_image']);
                $vendor_image = $request->file('vendor_image');
                $data['vendor_image'] = rand(11111, 99999).'.'.$vendor_image->getClientOriginalExtension();
                $vendor_image->move($destinationPath, $data['vendor_image']);
            }

            if($request->hasFile('vendor_logo')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                File::delete($destinationPath . $data['vendor_logo']);
                $vendor_logo = $request->file('vendor_logo');
                $data['vendor_logo'] = rand(11111, 99999).'.'.$vendor_logo->getClientOriginalExtension();
                $vendor_logo->move($destinationPath, $data['vendor_logo']);
            }

            Vendor::where('id',$data['id'])->update($data);
            session()->flash('warning',Lang::get('leftsidebar.Updated'));
        }
        return redirect('admin/vendorsInfo');
    }



    

    public function deleteVendor($id){
        $vendor =Vendor::where('id',$id)->first();
        $destinationPath = public_path('Admin_uploads/Vendors/');                 
        File::delete($destinationPath . $vendor->vendor_image );
        File::delete($destinationPath . $vendor->vendor_logo );
        Vendor::where('id',$id)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return back();
    }







}
