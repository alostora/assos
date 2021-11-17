<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Sub_category;
use App\Models\Category;
use App\Models\Item;
use App\Models\User_fav_item;
use App\Models\User;
use App\Models\Review;
use App\Models\Item_property_plus;
use App\Models\Item_properity;
use App\Models\Property;
use App\Models\Sub_property;
use App\Models\Sort_type;
use URL;
use Lang;


class Users extends Controller
{
    

    public function vendors(){
        $data['status'] = true;
        $data['vendors'] = Vendor::get(['id','vendor_name','vendor_image']);

        if(!empty($data['vendors'])){
            foreach($data['vendors'] as $key => $vend){
                $vend->vendor_image = URL::to('Admin_uploads/vendors/'.$vend->vendor_image);
            }
        }
        return $data;
    }




    public function vendorCategories(Request $request,$vendor_id){
        
        $data['status'] = true;

        $data['categories'] = Category::with('sub_categories')->get();
        $vendor_sub_cats_id = Item::where('vendor_id',$vendor_id)->pluck('sub_cat_id');
        if(!empty($vendor_sub_cats_id)) {
            $vendor_cats_id = Sub_category::whereIn('id',$vendor_sub_cats_id)->pluck('cat_id');
            if(!empty($vendor_cats_id)) {
                $data['categories'] = Category::with('sub_categories')->whereIn('id',$vendor_cats_id)->get();
            }
        }

        if(!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                $cat->categoryName = $request->header('accept-language') == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                        $sub_cat->categoryName = $request->header('accept-language') == 'en' ? $sub_cat->categoryName : $sub_cat->categoryNameAr;
                    }
                }
            }
        }
        return $data;
    }




    public function categories(Request $request){

        $data['status'] = true;
        $data['categories'] = Category::with('sub_categories')->get();
        
        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                $cat->categoryName = $request->header('accept-language') == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                        $sub_cat->categoryName = $request->header('accept-language') == 'en' ? $sub_cat->categoryName : $sub_cat->categoryNameAr;
                    }
                }
            }
        }
        return $data;
    }




    public function items(Request $request,$s_cat_id,$vendor_id=false){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        if (!empty($user)){
            
            $data['status'] = true;
            if($vendor_id == false) {
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->paginate(20);
            }else{
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->where('vendor_id',$vendor_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->paginate(20);
            }

            if(!empty($data['items'])){
                foreach($data['items'] as $item){

                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;
                }
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
       
        return $data;
    }




    public function itemInfo(Request $request,$itemId){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        $lang = $request->header('accept-language');
        if(!empty($user)){

            $data['status'] = true;
            $data['item'] = Item::where('id',$itemId)
            ->with('other_item_images')
            ->with(['reviews'=>function($query){
                $query->limit(3);
            }])->first();

            if(!empty($data['item'])){
                $data['item']->itemName = $lang == 'en' ? $data['item']->itemName : $data['item']->itemNameAr;

                $data['item']->itemDescribe = $lang == 'en' ? $data['item']->itemDescribe : $data['item']->itemDescribeAr;

                if(!empty($data['item'])) {
                    $data['item']->vendor_info = Vendor::find($data['item']->vendor_id);
                    $data['item']->vendor_info->vendor_image = URL::to('Admin_uploads/vendors/'.$data['item']->vendor_info->vendor_image);

                    if(count($data['item']->other_item_images)) {
                        foreach($data['item']->other_item_images as $otherImage){
                            $otherImage->itemImageName = URL::to('uploads/itemImages/'.$otherImage->itemImageName);
                        }
                    }

                    if(count($data['item']->reviews)) {
                        foreach($data['item']->reviews as $review){
                            $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);
                            $review->user_info->image = URL::to('Admin_uploads/vendors/'.$review->user_info->image);
                        }
                    }

                    //item property belongs to items
                    $item_properties = Item_properity::where('item_id',$data['item']->id)->pluck('id');
                    //item property belongs to item properties
                    $item_properties_plus = Item_property_plus::whereIn('properity_id',$item_properties)->pluck('sub_prop_id');
                    //item property belongs to admin properties
                    $sub_prop = Sub_property::whereIn('id',$item_properties_plus)->get();
                    if(!empty($sub_prop)) {
                        $color = [];
                        $size = [];
                        foreach($sub_prop as $pro){
                            $pro->propertyName = $lang == 'en' ? $pro->propertyName : $pro->propertyNameAr;
                            $main_admin_prop = Property::find($pro->prop_id);
                            if (!empty($main_admin_prop) && $main_admin_prop->type == 'color') {
                                array_push($color, $pro);
                            }elseif(!empty($main_admin_prop) && $main_admin_prop->type == 'size'){
                                array_push($size, $pro);
                            }
                        }
                    }

                    $data['item']->color = $color;
                    $data['item']->size = $size;

                    $data['item']->itemImage = URL::to('uploads/itemImages/'.$data['item']->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$data['item']->id)->first();

                    $data['item']->itemMayLike = Item::limit(10)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

                    if (!empty($data['item']->itemMayLike)) {
                        foreach($data['item']->itemMayLike as $itemMayLike){
                            $itemMayLike->itemName = $request->header('accept-language') == 'en' ? $itemMayLike->itemName : $itemMayLike->itemNameAr;

                            $itemMayLike->itemImage = URL::to('uploads/itemImages/'.$itemMayLike->itemImage);
                            $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemMayLike->id)->first();
                            $itemMayLike->fav = !empty($fav) ? true : false;
                            $itemMayLike->cart = false;
                        }
                    }

                    $data['item']->itemFit = Item::limit(10)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

                    if(!empty($data['item']->itemFit)) {
                        foreach($data['item']->itemFit as $itemFit){
                            $itemFit->itemName = $request->header('accept-language') == 'en' ? $itemFit->itemName : $itemFit->itemNameAr;

                            $itemFit->itemImage = URL::to('uploads/itemImages/'.$itemFit->itemImage);
                            $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemFit->id)->first();
                            $itemFit->fav = !empty($fav) ? true : false;
                            $itemFit->cart = false;
                        }
                    }

                    $data['item']->fav = !empty($fav) ? true : false;
                    $data['item']->cart = false;
                }
            }else{
                $data['status'] = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function addItemToFav(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            $user_fav = User_fav_item::where(['item_id'=>$item_id,'user_id'=>$user_id])->first();
            if(!empty(Item::find($item_id))){
                if (empty($user_fav)) {
                    User_fav_item::create([
                        'item_id'=>$item_id,
                        'user_id'=>$user_id
                    ]);
                }
            }

            $data['status'] = true;
            $data['message'] = 'item add to fav success';
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function removeItemFromFav(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            User_fav_item::where('user_id',$user_id)->where('item_id',$item_id)->delete();

            $data['status'] = true;
            $data['message'] = 'item deleted from fav success';
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function userItemsFav(Request $request){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();
            
        if(!empty($user)) {
            $user_id = $user->id;
            $data['status'] = true;

            $fav_item_id = User_fav_item::where('user_id',$user_id)->get();
            $data['items'] = Item::whereIn('id',$fav_item_id)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis']);

            if(!empty($data['items'])){
                foreach($data['items'] as $item){
                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;

                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribe;
                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;
                }
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function userItemReview(Request $request){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();
        $item = Item::find($request->item_id);
            
        if(!empty($user)) {
            $user_id = $user->id;
            $item = Item::find($request->item_id);
            if(!empty($item)) {
                $data['status'] = true;
                $data['message'] = 'review add';
                Review::create([
                    'rate'=>$request->rate,
                    'comment'=>$request->comment,
                    'user_id'=>$user->id,
                    'item_id'=>$item->id,
                ]);

            $itemSumRate = Review::where('item_id',$item->id)->sum('rate');    
            $itemRateCount = Review::where('item_id',$item->id)->count();
            $itemAverageRate = $itemSumRate / $itemRateCount;
            $item->rate = $itemAverageRate;
            $item->save();

            }else{
                $data['status'] = false;
                $data['message'] = 'item not found';
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function itemReviews(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        $data['status'] = true;
        $data['reviews'] = Review::where('item_id',$item_id)->get();

        if(!empty($data['reviews'])){
            foreach($data['reviews'] as $review){
                $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);
                $review->user_info->image = URL::to('Admin_uploads/vendors/'.$review->user_info->image);
            }  
        }

        return $data;
    }




    //still only example
    public function itemMayLike(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        
        $data['status'] = true;
        $data['items'] = Item::/*where('id',$item_id)->*/get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);


        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;

                $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'item not found';
        }

        return $data;
    }




    public function itemFit(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        $data['status'] = true;
        $data['items'] = Item::/*where('id',$item_id)->*/get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'item not found';
        }

        return $data;
    }




    public function properties(Request $request){
        $data['status'] = true;
        $prop_ids = Property::pluck('id');
        $sub_props = Sub_property::whereIn('prop_id',$prop_ids)->get();
        $lang = $request->header('accept-language');

        if (!empty($sub_props)) {

            $data['color'] = [];
            $data['clothes_size'] = [];
            $data['shoes_size'] = [];

            foreach($sub_props as $sub_prop){
                $sub_prop->propertyName = $lang == 'en' ? $sub_prop->propertyName : $sub_prop->propertyNameAr;
                $prop = Property::find($sub_prop->prop_id);

                if(!empty($prop) && $prop->type == 'color'){
                    array_push($data['color'],$sub_prop);
                }elseif(!empty($prop) && $prop->type == 'clothes_size'){
                    array_push($data['clothes_size'],$sub_prop);
                }elseif(!empty($prop) && $prop->type == 'shoes_size'){
                    array_push($data['shoes_size'],$sub_prop);
                }
            }
        }

        return $data;
    }




    public function itemSearch(Request $request){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if(!empty($user)) {

            $data['status'] = true;
            $items = Item::query();
           
            if(!empty($request->itemNameSearch)) {
                $items->where('itemNAme','like',"%".$request->itemNameSearch."%")
                ->orWhere('itemNAmeAr','like',"%".$request->itemNameSearch."%");
            }

            if(!empty($request->vendor_id)){
                if (is_array($request->vendor_id)) {
                    $items->whereIn('vendor_id',$request->vendor_id);
                }
            }

            if(!empty($request->cats_ids)){
                if (is_array($request->cats_ids)) {

                    $cats =  Category::whereIn('id',$request->cats_ids)->pluck('id');
                    if(!empty($cats)) {
                        $sub_cats = Sub_category::whereIn('cat_id',$cats)->pluck('id');

                        if($sub_cats) {
                            $items->whereIn('sub_cat_id',$sub_cats);
                        }
                    }
                }
            }
            
            if(!empty($request->sub_cat_ids)){
                if (is_array($request->sub_cat_ids)) {
                    $items->whereIn('sub_cat_id',$request->sub_cat_ids);
                }
            }

            if(!empty($request->sub_prop_ids)){
                if (is_array($request->sub_prop_ids)) {
                    $sub_prop_ids = Item_property_plus::whereIn('sub_prop_id',$request->sub_prop_ids)->pluck('properity_id');
                    if (!empty($sub_prop_ids)) {
                        $main_prop_ids = Item_properity::whereIn('id',$sub_prop_ids)->pluck('item_id');
                        if (!empty($main_prop_ids)) {
                            $items->whereIn('id',$main_prop_ids);
                        }
                    }
                }
            }

            if( !empty($request->minPrice) && !empty($request->maxPrice) ){
                $items->whereBetween('itemPrice',[$request->minPrice,$request->maxPrice]);
            }


            if($request->sortType == 'priceASC'){
                $items->orderBy('itemPrice','ASC');
            }

            if($request->sortType == 'priceDESC') {
                $items->orderBy('itemPrice','DESC');
            }

            if($request->sortType == 'rateASC') {
                $items->orderBy('rate','ASC');
            }

            if($request->sortType == 'rateDESC') {
                $items->orderBy('rate','ASC');
            }
        
            $data['items'] = $items->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->paginate(25);

            if(!empty($data['items'])){
                foreach($data['items'] as $item){

                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function sortType(Request $request){
        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if(!empty($user)) {
            $data['status'] = true;
            $data['sortType'] = Sort_type::get();

            if(!empty($data['sortType'])) {
                foreach($data['sortType'] as $sType){
                    $sType->sortTypeName = $request->header('accept-language') == 'en' ? $sType->sortTypeName : $sType->sortTypeNameAr;
                }  
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }

        return $data;
    }






}
