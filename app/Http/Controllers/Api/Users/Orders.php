<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Order_item_prop;
use App\Models\Item_property_plus;
use App\Models\Sub_property;
use App\Models\Property;
use App\Models\User_address;
use App\Models\Order_setting;
use App\Models\Discount_copon;
use App\Models\user_discount_copon;
use App\Models\Item_back_reason;
use App\Models\Item_back_request;
use App\Models\Review;
use App\Models\User_fav_item;
use App\Models\Vendor;
use App\Helpers\Helper;
use Auth;
use URL;
use Validator;
use Str;
use Lang;
use Carbon\Carbon;


class Orders extends Controller
{


    public function makeOrder(Request $request){


        if(Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }


        if (!empty($user)) {

            $item = Item::find($request->item_id);
            if (!empty($item)){
                $count = !empty($request->count) ? $request->count : 1;
                $itemPrice = $item->itemPriceAfterDis * $count;
                $order = Order::where(['user_id'=>$user->id,'status' => "new"])->first();

                if(empty($order)) {
                    $order = Order::create([
                        'user_id' => $user->id,
                        "total_price" => $itemPrice,
                        "orderCode" => Str::random(8),
                    ]);

                    $order_item = Order_item::create([
                        "item_id" => $item->id,
                        "item_count" => $count,
                        "order_id" => $order->id,
                        "itemPrice" => $item->itemPriceAfterDis,
                    ]);

                }else{

                    $order_item = Order_item::create([
                        "item_id" => $item->id,
                        "item_count" => $count,
                        "order_id" => $order->id,
                        "itemPrice" => $item->itemPriceAfterDis,
                    ]);

                    $order->total_price = $order->total_price + $itemPrice;
                    $order->save();
                }

                if(!empty($request->props) && is_array($request->props)) {
                    foreach($request->props as $requestProp){
                        Order_item_prop::create([
                            'order_item_id' => $order_item->id,
                            'item_prop_id' => $requestProp,
                        ]);
                    }
                }

                $data['status'] = true;
                $data['message'] = Lang::get('leftsidebar.Created');

            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Error');
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Error');
        }

        return $data;
    }




    public function getOrder(Request $request){
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $lang = $request->header('accept-language');

        if(!empty($user)){
            $order = Order::where(['user_id'=>$user->id,'status'=>'new'])
                    ->with(['order_items'=>function($query){
                        $query->with('order_items_props');
                    }])->first();

            if(!empty($order)){
                $orderSetting = Order_setting::where('settingName',$order->shippingType)->first();
                if (empty($orderSetting)) {
                    $orderSetting = Order_setting::where('settingName','normalShipping')->first();
                }

                $order->date = date("D d M,Y",strtotime($order->created_at));
                $order->shippingAddress = User_address::find($order->shippingAddress_id);
                if(count($order->order_items)){
                    foreach($order->order_items as $orderItem){
                        $item = Item::find($orderItem->item_id);
                        if(!empty($item)) {
                            $orderItem->itemName = $lang != 'ar' ? $item->itemName : $item->itemNameAr;
                            $orderItem->itemPrice = $item->itemPrice;
                            $orderItem->itemPriceAfterDis = $item->itemPriceAfterDis;
                            $orderItem->discountValue = $item->discountValue;
                            $orderItem->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);


                            $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                            $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();

                            $orderItem->review = !empty($review) ? true : false;
                            $orderItem->fav = !empty($fav) ? true : false;
                            $orderItem->cart = true;


                            $orderItem->vendor_info = Vendor::find($item->vendor_id);
                            $orderItem->vendor_info->vendor_image = URL::to('Admin_uploads/vendors/'.$orderItem->vendor_info->vendor_image);
                            $orderItem->vendor_info->vendor_logo = URL::to('Admin_uploads/vendors/'.$orderItem->vendor_info->vendor_logovendor_logo);


                            if(count($orderItem->order_items_props)){
                                foreach($orderItem->order_items_props as $itemProp){
                                    $itemPropPlus = Item_property_plus::find($itemProp->item_prop_id);
                                    if($itemPropPlus) {
                                        $itemSubProp= Sub_property::find($itemPropPlus->sub_prop_id);
                                        if(!empty($itemSubProp)) {
                                            $itemProp->propertyName = $lang != 'ar' ? $itemSubProp->propertyName : $itemSubProp->propertyNameAr;

                                            $mainProp = Property::find($itemSubProp->prop_id);
                                            if(!empty($mainProp)) {
                                                $itemProp->type = $mainProp->type;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $data['status'] = true;
                $data['order'] = $order;
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }






    public function getAllOrders(Request $request){
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $lang = $request->header('accept-language');

        if(!empty($user)){
            $orders = Order::where(['user_id'=>$user->id])->where('status','!=','new')
                    ->with(['order_items'=>function($query){
                        $query->with('order_items_props');
                    }])->get();

            if(!empty($orders)){

                foreach($orders as $order){
                    $order->date = date("D d M,Y",strtotime($order->created_at));
                    $order->canBack = $order->date >= Carbon::now()->subDays(15) ? true : false;
                    $order->shippingAddress = User_address::find($order->shippingAddress_id);
                    $orderSett = Order_setting::where('settingName','normalShipping')->first();
                    $order->expectedDate = "expeted arrival date is after ".$orderSett->settingOptions ." days";

                    if(count($order->order_items)){
                        foreach($order->order_items as $orderItem){
                            $item = Item::find($orderItem->item_id);
                            if(!empty($item)) {
                                $orderItem->itemName = $lang != 'ar' ? $item->itemName : $item->itemNameAr;
                                $orderItem->itemPrice = $item->itemPrice;
                                $orderItem->itemPriceAfterDis = $item->itemPriceAfterDis;
                                $orderItem->discountValue = $item->discountValue;
                                $orderItem->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);

                                if(count($orderItem->order_items_props)){
                                    foreach($orderItem->order_items_props as $itemProp){
                                        $itemPropPlus = Item_property_plus::find($itemProp->item_prop_id);
                                        if($itemPropPlus) {
                                            $itemSubProp= Sub_property::find($itemPropPlus->sub_prop_id);
                                            if(!empty($itemSubProp)) {
                                                $itemProp->propertyName = $lang != 'ar' ? $itemSubProp->propertyName : $itemSubProp->propertyNameAr;

                                                $mainProp = Property::find($itemSubProp->prop_id);
                                                if(!empty($mainProp)) {
                                                    $itemProp->type = $mainProp->type;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


                $data['status'] = true;
                $data['order'] = $orders;
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





    public function deleteItem(Request $request,$itemId){


        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        if(!empty($user)){
            $order = Order::where(['user_id'=>$user->id])->where('status','new')->first();

            if(!empty($order)){

                $orderItems = Order_item::where('order_id',$order->id)->get();
                if(!empty($orderItems) && count($orderItems) <= 1){
                    $order->delete();
                }else{
                    Order_item::where(['item_id'=>$itemId,'order_id'=>$order->id])->delete();
                }

                $data['status'] = true;
                $data['message'] = Lang::get('leftsidebar.Deleted');

            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;

    }






    public function deleteOrderItem(Request $request,$itemId){


        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $orderItem = Order_item::find($itemId);
        if (empty($orderItem)) {
            $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
            if (!empty($order)) {
                $orderItem = Order_item::where(['order_id'=>$order->id,'item_id'=>$itemId])->first();
            }
        }

        if (!empty($orderItem)){
            $order =Order::where('id',$orderItem->order_id)->first();
            $count_order_items =Order_item::where('order_id',$orderItem->order_id)->count();

            if($count_order_items > 1) {

                $mainItem = Item::where('id', $orderItem->item_id)->first();
                if (!empty($mainItem)) {
                    $itemPrice = $mainItem->itemPriceAfterDis * $orderItem->item_count;
                    $order->total_price = $order->total_price- $itemPrice;
                    $order->save();
                }
                $orderItem->delete();
            }else{
                Order::where('id',$orderItem->order_id)->delete();
            }

            $data['status'] = true;
            $data['message'] = Lang::get('leftsidebar.Deleted');

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }






    public function itemCountPlus($orderItemId){

        $orderItem = Order_item::find($orderItemId);
        if(!empty($orderItem)) {
            $mainItem = Item::find($orderItem->item_id);

            if (!empty($mainItem)) {
                $itemPrice = $mainItem->itemPriceAfterDis;
                $orderItem->item_count = $orderItem->item_count + 1;
                $order = Order::find($orderItem->order_id);

                if (!empty($order)) {
                    $order->total_price = $itemPrice + $order->total_price;
                    $order->save();
                    $orderItem->save();

                    $data['status'] = true;
                    $data['message'] = Lang::get('leftsidebar.Done') . "+1";
                }else{
                    $data['status'] = false;
                    $data['message'] = Lang::get('leftsidebar.Empty');
                }
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





    public function itemCountMinus($orderItemId){

        $orderItem = Order_item::find($orderItemId);
        if(!empty($orderItem)) {
            $mainItem = Item::find($orderItem->item_id);

            if (!empty($mainItem)) {
                $itemPrice = $mainItem->itemPriceAfterDis;
                if(($orderItem->item_count - 1) > 0) {

                    $orderItem->item_count = $orderItem->item_count - 1;
                    $order = Order::find($orderItem->order_id);

                    if (!empty($order)) {
                        $order->total_price = $order->total_price - $itemPrice;
                        $order->save();
                        $orderItem->save();

                        $data['status'] = true;
                        $data['message'] = Lang::get('leftsidebar.Done') . "-1";
                    }else{
                        $data['status'] = false;
                        $data['message'] = Lang::get('leftsidebar.Empty');
                    }
                }else{
                    $data['status'] = false;
                    $data['message'] = Lang::get('leftsidebar.Error') ."0";
                }
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }






    public function checkOutDetails(Request $request){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $lang = $request->header('accept-language');

        if(!empty($user)){
            $status = ["new","confirmed"];
            $order = Order::where(['user_id'=>$user->id])->whereIn('status',$status)
                    ->first();

            if(!empty($order)){

                $orderSetting = Order_setting::get();
               if (!empty($orderSetting)) {
                    foreach($orderSetting as $setting){
                        $setting->settingOptions =  $setting->settingOptions ? "expeted arrival date is after ".$setting->settingOptions ." days" : "";
                    }
                }


                $order->shippingAddress = User_address::where(['user_id'=>$user->id,'isMain'=>true])->first();
                $order->orderSetting = $orderSetting;

                $data['status'] = true;
                $data['data'] = $order;
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }






    public function checkOut(Request $request,$orderId){
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        if(!empty($user)){
            $order = Order::find($orderId);
            if(!empty($order) && $order->status == "new"){
                $order->status = "confirmed";
                $order->save();
                $data['status'] = true;
                $data['message'] = Lang::get('leftsidebar.Done');
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Error');
            }
        }else{

        }

        return $data;
    }





    public function orderCopon(Request $request){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $discountCopon = Discount_copon::where('code',$request->code)->first();

        if (!empty($discountCopon)) {
            $today = strtotime(date("Y-m-d"));
            $dateTo = strtotime($discountCopon->dateTo);
            $dateFrom = strtotime($discountCopon->dateFrom);

            if($today > $dateTo or $today < $dateFrom){
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Error');
            }else{
                $order = Order::find($request->order_id);
                if(!empty($order)){

                    $vendorItems = Item::where('vendor_id',$discountCopon->vendor_id)->pluck('id');
                    $vendorItems = array_unique($vendorItems->toArray());
                    $orderItems = Order_item::where('order_id',$order->id)->whereIn('item_id',$vendorItems)->get();


                    if(empty($orderItems)){
                        $data['status'] = false;
                        $data['message'] = $data['message'] = Lang::get('leftsidebar.Invalid');
                    }else{

                        $orderItems = Order_item::where('order_id',$order->id)->whereIn('item_id',$vendorItems)->pluck('item_id');
                        $orderItems = array_unique($orderItems->toArray());

                        $itemsTotalPrice = Item::whereIn('id',$orderItems)->sum('itemPriceAfterDis');

                        if($itemsTotalPrice <= $discountCopon->discountValue) {
                            $data['status'] = false;
                            $data['message'] = $data['message'] = Lang::get('leftsidebar.Invalid');
                            return $data;
                        }

                        $userCopon = user_discount_copon::where('user_id',$user->id)
                            ->where('copon_id',$discountCopon->id)->first();

                        if(empty($userCopon)) {

                            $order->discountCopon = $discountCopon->discountValue;
                            $order->save();

                            user_discount_copon::create([
                                'user_id'=>$user->id,
                                'copon_id'=>$discountCopon->id
                            ]);

                            $data['status'] = true;
                            $data['message'] = Lang::get('leftsidebar.Done');
                        }else{
                            $data['status'] = false;
                            $data['message'] = Lang::get('leftsidebar.Used');
                        }
                    }
                }else{
                    $data['status'] = false;
                    $data['message'] = Lang::get('leftsidebar.Empty');
                }

            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Invalid');
        }

        return $data;
    }





    //confirmOrder
    public function confirmOrder(Request $request){
        $info =$request->all();
        $validator = Validator::make($info,[
            'id' => 'required',
            'shippingType' => 'required',
            'paymentMethod' => 'required',
            'addedTax' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'shippingValue' => 'required',
            'shippingAddress_id' => 'required',
        ]);

        if (empty(User_address::find($request->shippingAddress_id))) {
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Error');
            return $data;
        }

        if ($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }

        $requestData = $request->all();
        $requestData['status'] = "confirmed";
        Order::where('id',$requestData['id'])->update($requestData);


        $data['status']=true;
        $data['message'] = Lang::get('leftsidebar.confirmed');

        return $data;
    }





    public function discountCopons(Request $request){
        $data['status']=true;
        $discountCopon = Discount_copon::get();
        if (!empty($discountCopon)) {
            foreach($discountCopon as $copon){
                $copon->vendor_info = Vendor::find($copon->vendor_id);
                $copon->vendor_info->vendor_image = URL::to('Admin_uploads/vendors/'.$copon->vendor_info->vendor_image);
                $copon->vendor_info->vendor_logo = URL::to('Admin_uploads/vendors/'.$copon->vendor_info->vendor_logo);
            }
        }
        $data['data'] = $discountCopon;
        return $data;
    }





    public function itemBackReasons(Request $request){

        $lang = $request->header('accept-language');
        $reasons = Item_back_reason::get();
        if (!empty($reasons)){
            foreach($reasons as $reason){
                $reason->backReasonName = $lang == 'en' ? $reason->backReasonName : $reason->backReasonArName;
            }
        }

        $data['status'] = true;
        $data['reasons'] = $reasons;

        return $data;
    }





    public function itemBackRequest(Request $request){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $info = $request->all();
        $validator = Validator::make($info,[
            'order_id' => 'required',
            'order_item_id' => 'required',
            'item_back_count' => 'required',
            'reason_id' => 'required',
        ]);

        $info['user_id'] = $user->id;
        Item_back_request::create($info);

        $data['status'] = true;
        $data['message'] = Lang::get('leftsidebar.Sent');
        return $data;
    }




    public function itemsCanBack(Request $request){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $lang = $request->header('accept-language');

        $orderSett = Order_setting::where('settingName','backDuration')->first();
        $orders = Order::where(['user_id'=>$user->id,'status'=>'completed'])->whereDate('created_at','>=',Carbon::now()->subDays(15))->pluck('id');
        $orders = array_unique($orders->toArray());


        $orderItems = Order_item::whereIn('order_id',$orders)->whereDate('created_at','>=',Carbon::now()->subDays(15))->get();
        $data['status'] = true;
        $data['message'] = Lang::get('leftsidebar.Products cannot be returned') ." ". $orderSett->settingValue;


        if(!empty($orderItems)) {
            foreach($orderItems as $orderItem){
                $order = Order::find($orderItem->order_id);
                $orderItem->orderDate = date('D d M,Y',strtotime($order->created_at));
                $orderItem->orderCode = $order->orderCode;
                $item = Item::where('id',$orderItem->item_id)->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->first();

                $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;

                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $reviewFit = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();

                $item->review = !empty($reviewFit) ? true : false;
                $item->fav = !empty($favFit) ? true : false;
                $item->cart = false;


                //item in cart?
                $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                if(!empty($order)){
                    $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                    if(!empty($order_item)) {
                        $item->cart = true;
                    }
                }
                $orderItem->item = $item;
            }

        }

        $data['items'] = $orderItems;
        return $data;
    }



     ///test and well delete
    public function changeOrderStatus(Request $request,$orderId,$status){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        if(!empty($user)){

            $orders = Order::where(['user_id'=>$user->id,'id'=>$orderId])->update(['status'=>$status]);
            $data['status'] = true;
            $data['message'] = Lang::get('leftsidebar.Updated '). $status;

            //start_notifi
            $info['users'] = User::where('id',$user->id)->get();
            $info['title'] = Lang::get('leftsidebar.'.$status);
            $info['body'] = Lang::get('leftsidebar.'.$status);
            return Helper::senNotifi($info);
            //end_notifi



        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





}
