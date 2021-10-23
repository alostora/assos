<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Hash;
use File;


class Vendors extends Controller
{
    public function vendorInfo(){
       $vendors= Vendor::get();
       return view('Admin/Vendors/vendorInfo',compact('vendors'));
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
          'password' => 'required|max:100',
          'confirm_password' => 'same:password',
          'address' => 'required|max:100',
          'vendor_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token','confirm_password');

        if (empty($data['id'])) {
            //add
            $data['vendor_image'] = null;

            if ($request->hasFile('vendor_image')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                $vendor_image = $request->file('vendor_image');
                $data['vendor_image'] = rand(11111, 99999).'.'.$vendor_image->getClientOriginalExtension();
                $vendor_image->move($destinationPath, $data['vendor_image']);
            }

            Vendor::create($data);
             }else{
            //edit
            $vendor = Vendor::find($data['id']);
            $data['vendor_image'] = $vendor->vendor_image;

            if ($request->hasFile('vendor_image')) {
                $destinationPath = public_path('Admin_uploads/vendors/');
                File::delete($destinationPath . $data['vendor_image']);
                $vendor_image = $request->file('vendor_image');
                $data['vendor_image'] = rand(11111, 99999).'.'.$vendor_image->getClientOriginalExtension();
                $vendor_image->move($destinationPath, $data['vendor_image']);
            }

            Vendor::where('id',$data['id'])->update($data);
        }

        $request->session()->flash('success','Done successfully');
        return redirect('admin/vendorInfo');
    }

    public function deleteVendor($id){
        $vendor =Vendor::where('id',$id)->first();
        $destinationPath = public_path('Admin_uploads/Vendors/');                 
        File::delete($destinationPath . $vendor->vendor_image );
        
        Vendor::where('id',$id)->delete();

        session()->flash('success','Done successfully');
        return back();
    }







}
