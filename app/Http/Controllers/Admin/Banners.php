<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use File;
use Lang;

class Banners extends Controller
{

    public function bannerInfo(){
        $data['banner'] = Banner::first();
        return view('Admin/Banners/bannerInfo',$data);
    }



    public function viewCreateBanner(){
        $data['banner'] = Banner::first();
        return view('Admin/Banners/viewCreateBanner',$data);
    }




    public function createBanner(Request $request){

        $validated = $request->validate([
          'link' => 'required|max:100',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);

        $banner = Banner::first();
        $destinationPath = public_path('Admin_uploads/banners/');

        if (!empty($banner)) {
            if ($request->hasFile('image')) {
                File::delete($destinationPath . $banner->image);
                $image = $request->file('image');
                $validated['image'] = rand(11111, 99999).'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $validated['image']);
            }
            Banner::where('id',$banner->id)->update($validated);
            session()->flash('warning',Lang::get('leftsidebar.Updated'));
        }else{
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $validated['image'] = rand(11111, 99999).'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $validated['image']);
            }
            Banner::create($validated);
            session()->flash('success',\Lang::get('leftsidebar.Created'));
        }


        return back();

    }






    public function deleteBanner(){
        $banner = Banner::first();
        $destinationPath = public_path('Admin_uploads/banners/');
        File::delete($destinationPath . $banner->image);
        $banner->delete();
        session()->flash('success',\Lang::get('leftsidebar.Deleted'));
        return back();
    }


}
