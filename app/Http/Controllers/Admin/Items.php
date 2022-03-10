<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Lang;

class Items extends Controller
{



    public function itemReviews(){
       $data['reviews'] = Review::get();
       return view('Admin/Reviews/itemReviews',$data);
    }





    public function changeReviewStatus($reviewId,$status){
        Review::where('id',$reviewId)->update(['status'=>$status]);
        session()->flash('success',Lang::get('leftsidebar.Updated'));
        return back();
    }



}
