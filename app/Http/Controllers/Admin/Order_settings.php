<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_setting;
use App\Models\Item_back_reason;
use Lang;


class Order_settings extends Controller
{
    




    public function orderSettings(){
        $data['settings'] = Order_setting::get();
        return view('Admin/OrderSettings/orderSettings',$data);
    }





    public function viewCreateOrderSettings($settingId=false){
        $data['setting']= false;
        if ($settingId != false) {
            $data['setting'] = Order_setting::find($settingId);
        }
        return view('Admin/OrderSettings/viewCreateOrderSettings',$data);
    }






    public function createSetting(Request $request){
        if (!empty($data['id'])) {
            $data = $request->except("_token","settingName","settingNameAr");
            Order_setting::where('id',$data['id'])->update($data);
        }else{
            $data = $request->except("_token");
            Order_setting::create($data);
        }
        session()->flash('warning',Lang::get('leftsidebar.Created'));
        return back();
    }





    public function deleteOrderSettings($settingId){
        Order_setting::where('id',$settingId)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return back();
    }

    //ItemBackReasons

    public function itemBackReasonsInfo(){
        $reasons= Item_back_reason::get();
        return view('Admin/itemBackReasons/itemBackReasonsInfo',compact('reasons'));

    }   

    public function viewCreateitemBackReason($id=false){
        $data['reason'] = false;
        if($id != false){
            $data['reason'] = Item_back_reason::find($id);
        }
        return view('Admin/itemBackReasons/viewCreateitemBackReason',$data);

    } 

    public function createitemBackReason(Request $request){

         $validated = $request->validate([
          'backReasonName' => 'required|max:255',
          'backReasonArName' => 'required|max:255',
        ]);

        if (!empty($request->id)) {
            Item_back_reason::where('id',$request->id)->update([
                'backReasonName' => $request->backReasonName,
                'backReasonArName' => $request->backReasonArName,
            ]);
            session()->flash('warning',Lang::get('leftsidebar.Updated')); 
        }else{
            Item_back_reason::create([
                'backReasonName' => $request->backReasonName,
                'backReasonArName' => $request->backReasonArName,
            ]);
            session()->flash('warning',Lang::get('leftsidebar.Created'));
        }
        return back();

    }

    public function deleteitemBackReason($id){
        Item_back_reason::where('id',$id)->delete();
        session()->flash('warning',Lang::get('leftsidebar.Deleted'));
        return back();
    }
    








}
