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
            $data['categories'] = Category::with('sub_categories')->get();
        }else{
            //"cat->sub_cat->item -> vendor_id"

            $vendor_sub_cats_id = Item::where('vendor_id',$vendor_id)->pluck('sub_cat_id');
            if(!empty($vendor_sub_cats_id)) {
                $vendor_cats_id = Sub_category::whereIn('id',$vendor_sub_cats_id)->pluck('cat_id');
                if(!empty($vendor_cats_id)) {
                    $data['categories'] = Category::with('sub_categories')->whereIn('id',$vendor_cats_id)->get();
                }
            }
        }


        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/'.$sub_cat->s_categoryImage);
                    }
                }
            }
        }

        return $data;

    }




    public function items($s_cat_id,$vendor_id=false){
        $data['status'] = true;

        if ($vendor_id == false) {
            $data['items'] = Item::where('sub_cat_id',$s_cat_id)->select(['itemName','itemImage','itemPrice','itemPriceAfterDis'])->paginate(20);
        }else{
            $data['items'] = Item::where('sub_cat_id',$s_cat_id)->where('vendor_id',$vendor_id)->select(['itemName','itemImage','itemPrice','itemPriceAfterDis'])->paginate(20);
        }

        foreach($data['items'] as $itemImage){
            $itemImage->itemImage = URL::to('uploads/itemImages/'.$itemImage->itemImage);

            $itemImage->fav = false;
            $itemImage->cart = false;

        }

        return $data;
    }






}
