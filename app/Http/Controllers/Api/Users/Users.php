<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Item;
use App\Models\Sub_category;
use URL;

class Users extends Controller
{
    

    public function vendors(){
        $data['status'] = true;
        $data['vendors'] = Vendor::get(['id','vendor_name','vendor_image']);

        if(!empty($data['vendors'])){
            foreach($data['vendors'] as $vend){
                $vend->vendor_image = URL::to('Admin_uploads/vendors/'.$vend->vendor_image);
            }
        }
        return $data;
    }




    public function categories($vendor_id=false){
        $data['status'] = true;
        $data['categories'] = [];

        if($vendor_id == false){
            $data['categories'] = Category::get();
        }else{
            //"cat->sub_cat->item -> vendor_id"

            $vendor_sub_cats_id = Item::where('vendor_id',$vendor_id)->pluck('sub_cat_id');
            if(!empty($vendor_sub_cats_id)) {
                $vendor_cats_id = Sub_category::whereIn('id',$vendor_sub_cats_id)->pluck('cat_id');
                if(!empty($vendor_cats_id)) {
                    $data['categories'] = Category::whereIn('id',$vendor_cats_id)->get();
                }
            }
        }


        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
            }
        }

        return $data;

    }


}
