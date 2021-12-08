<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Vendor;
use App\Models\Category;
use File;

class Ads extends Controller
{
    public function adsInfo(){
       $ads= Ad::get();
        return view('Admin/Ads/adsInfo',compact('ads'));
    }





    public function viewCreateAd($id=null){

        $data['vendors'] = Vendor::get();
        $data['categories'] = Category::get();

        if($id != null){
            $data['ad'] = Ad::find($id);
        }
    
        return view('Admin/Ads/viewCreateAd',$data);
    }





    public function createAd(Request $request){
        $validated = $request->validate([
          'adImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);

        $data = $request->except('_token');

         if(!empty($data)){
            
            $destinationPath = public_path('Admin_uploads/ads/');
            
            if ($data['id'] == null) {
                $data['adImage'] = null;

                if ($request->hasFile('adImage')) {
                    
                    $adImage = $request->file('adImage');
                    $data['adImage'] = rand(11111, 99999).'.'.$adImage->getClientOriginalExtension();
                    $adImage->move($destinationPath, $data['adImage']);
                }
                Ad::create($data);
            }else{
                $ad = Ad::find($data['id']);
                $data['adImage'] = $ad->adImage;

                if ($request->hasFile('adImage')) {
                    
                    File::delete($destinationPath . $data['adImage']);
                    $adImage = $request->file('adImage');
                    $data['adImage'] = rand(11111, 99999).'.'.$adImage->getClientOriginalExtension();
                    $adImage->move($destinationPath, $data['adImage']);
                }
                Ad::where('id',$data['id'])->update($data);
            }
        }

        session()->flash("success","done");
        return back(); 
    }





    public function deleteAd($id){
        $ad = Ad::find($id);
        if(!empty($ad)){
            $destinationPath = public_path('Admin_uploads/ads/');
            File::delete($destinationPath . $ad->adImage);
            $ad->delete();
        }

        session()->flash('warning','deleted');
        return back();
    }


}
