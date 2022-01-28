<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount_copon;
use App\Models\User;
use App\Helpers\Helper;
use Lang;
use Str;
use Auth;

class Copons extends Controller
{
    


    public function coponsInfo(){
       $data['copons'] = Discount_copon::where('vendor_id',Auth::guard('vendor')->id())->get();
        return view('Vendors/Copons/coponsInfo',$data);
    }





    public function viewCreateCopon($id=null){
        $data['copon'] = null;
        if($id != null){
            $data['copon'] = Discount_copon::find($id);
        }
    
        return view('Vendors/Copons/viewCreateCopon',$data);
    }





    public function createCopon(Request $request){
        $validated = $request->validate([
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'discountValue' => 'required|max:5',
        ]);

        $data = $request->except('_token');
        $data['vendor_id'] = Auth::guard('vendor')->id();

         if(!empty($data)){
            if ($data['id'] == null) {
                $data['code'] = Str::random(4);
                Discount_copon::create($data);

                //start_notifi
                $info['users'] = User::where('country',Auth::guard('vendor')->user()->country)->get();
                $info['title'] = Lang::get('leftsidebar.New copon add');
                $info['body'] = Lang::get('leftsidebar.use this copon '). $data['code'] . Lang::get(' leftsidebar.to buy from ')  . Auth::guard('vendor')->user()->vendor_name;
                $info['type'] = 'copon';
                Helper::senNotifi($info);
                //end_notifi

            }else{
                Discount_copon::where('id',$data['id'])->update($data);
            }
        }
        session()->flash("success","done");
        return back(); 
    }





    public function deleteCopon($id){
        $discount_copon = Discount_copon::where('id',$id)->delete();
        session()->flash('warning','deleted');
        return back();
    }





}
