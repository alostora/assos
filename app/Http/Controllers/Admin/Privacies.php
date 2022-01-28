<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacy;
use Lang;


class Privacies extends Controller
{
    
    public function privacyInfo(){
        $data['privacies'] = Privacy::get();
        return view('Admin/Privacies/privacyInfo',$data);
    }





    public function viewCreatePrivacy($privacyId=false){

        $data['privacy'] = "";

        if($privacyId != false){
            $data['privacy'] = Privacy::find($privacyId);
        }
        return view('Admin/Privacies/viewCreatePrivacy',$data);
    }







    public function createPrivacy(Request $request){
        $data = $request->except('_token');
        if (!empty($request->id)){
            Privacy::where('id',$request->id)->update($data);
            session()->flash('warning',Lang::get('leftsidebar.Updated'));
        }else{
            Privacy::create($data);
            session()->flash('warning',Lang::get('leftsidebar.Created'));
        }

        return back();
    }





    public function deletePrivacy(Request $request,$privacyId){
        Privacy::where('id',$privacyId)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return back();
    }



}
