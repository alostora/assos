<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;

class Ads extends Controller
{
    public function adsInfo(){
       $ads= Ad::get();
        return view('Admin/Ads/adsInfo',compact('ads'));
    }

    public function viewCreateAd($id=null){
    
        return view('Admin/Ads/viewCreateAd');
    }

    public function createAd(Request $request){
        $validated = $request->validate([
          'adLink' => 'required|max:255',
          'adImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);

        $data = $request->except('_token');

        $data['adImage'] = null;

        if ($request->hasFile('adImage')) {
            $destinationPath = public_path('Admin_uploads/ads/');
            $adImage = $request->file('adImage');
            $data['adImage'] = rand(11111, 99999).'.'.$adImage->getClientOriginalExtension();
            $adImage->move($destinationPath, $data['adImage']);
        }
        Ad::create($data);

        session()->flash("success","done");
        return back();

    }


}
