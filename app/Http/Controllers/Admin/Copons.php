<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount_copon;
use Str;

class Copons extends Controller
{
    


    public function coponsInfo(){
       $data['copons'] = Discount_copon::get();
        return view('Admin/Copons/coponsInfo',$data);
    }





    public function viewCreateCopon($id=null){
        $data['copon'] = null;
        if($id != null){
            $data['copon'] = Discount_copon::find($id);
        }
    
        return view('Admin/Copons/viewCreateCopon',$data);
    }





    public function createCopon(Request $request){
        $validated = $request->validate([
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'discountValue' => 'required|max:5',
        ]);

        $data = $request->except('_token');
        $data['code'] = Str::random(4);

         if(!empty($data)){
            if ($data['id'] == null) {
                Discount_copon::create($data);
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
