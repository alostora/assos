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
use Auth;
use URL;
use Validator;
use Str;
use lang;
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
                        'status' => "new",
                        "total_price" => $itemPrice,
                        "orderCode" => Str::random(8),
                    ]);
                }else{
                    $this->deleteOrderItem($item->id);
                    $order->total_price = (int)$order->total_price + (int)$itemPrice;
                    $order->save();
                }
                        

                $order_item = Order_item::create([
                    "item_id" => $request->item_id,
                    "item_count" => $count,
                    "order_id" => $order->id,
                    "itemPrice" => Item::find($request->item_id)->itemPriceAfterDis,
                ]);

                if(!empty($request->props) && is_array($request->props)) {
                    foreach($request->props as $requestProp){
                        Order_item_prop::create([
                            'order_item_id' => $order_item->id,
                            'item_prop_id' => $requestProp,
                        ]);
                    }
                }

                $data['status'] = true;
                $data['message'] = "item add to cart";

            }else{
                $data['status'] = false;
                $data['message'] = "plz choose correct item";
            }

        }else{
            $data['status'] = false;
            $data['message'] = "user not found";
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
                $data['message'] = "empty orders";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "user not found";
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

        $orderSetting = Order_setting::get();

        if(!empty($user)){
            $orders = Order::where(['user_id'=>$user->id])->where('status','!=','new')
                    ->with(['order_items'=>function($query){
                        $query->with('order_items_props');
                    }])->get();

            if(!empty($orders)){

                foreach($orders as $order){
                    $order->date = date("D d M,Y",strtotime($order->created_at));
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
                $data['message'] = "empty orders";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "user not found";
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
                $data['message'] = "item deleted";

            }else{
                $data['status'] = false;
                $data['message'] = "empty orders";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "user not found";
        }

        return $data;

    }






    public function deleteOrderItem($itemId){
        
        $orderItem = Order_item::find($itemId);
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
                Order_item::where('id',$itemId)->delete();
            }else{
                Order::where('id',$orderItem->order_id)->delete();
            }

            $data['status'] = true;
            $data['message'] = 'item deleted';

        }else{
            $data['status'] = false;
            $data['message'] = 'item not found';
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
                    $data['message'] = "item count plus 1";
                }else{
                    $data['status'] = false;
                    $data['message'] = "order not found";
                }
            }else{
                $data['status'] = false;
                $data['message'] = "main item not found";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "order item not found";
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
                        $data['message'] = "item count minus 1";
                    }else{
                        $data['status'] = false;
                        $data['message'] = "order not found";
                    }
                }else{
                    $data['status'] = false;
                    $data['message'] = "item cant be 0";
                }
            }else{
                $data['status'] = false;
                $data['message'] = "main item not found";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "order item not found";
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
                $data['message'] = "empty orders";
            }
        }else{
            $data['status'] = false;
            $data['message'] = "user not found";
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
                $data['message'] = "order status changed";
            }else{
                $data['status'] = false;
                $data['message'] = "order Can't changed";
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
                $data['message'] = "invalid copon";
            }else{
                $order = Order::find($request->order_id);
                if(!empty($order)){

                    $vendorItems = Item::where('vendor_id',$discountCopon->vendor_id)->pluck('id');
                    $vendorItems = array_unique($vendorItems->toArray());
                    $orderItems = Order_item::where('order_id',$order->id)->whereIn('item_id',$vendorItems)->get();


                    if(empty($orderItems)){
                        $data['status'] = false;
                        $data['message'] = "you cant use this copon with this items";
                    }else{

                        $orderItems = Order_item::where('order_id',$order->id)->whereIn('item_id',$vendorItems)->pluck('item_id');
                        $orderItems = array_unique($orderItems->toArray());

                        $itemsTotalPrice = Item::whereIn('id',$orderItems)->sum('itemPriceAfterDis');

                        if($itemsTotalPrice <= $discountCopon->discountValue) {
                            $data['status'] = false;
                            $data['message'] = "invalid copon item price less than discount copon";
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
                            $data['message'] = "copon used successfully";
                        }else{
                            $data['status'] = false;
                            $data['message'] = "you already used this copon";
                        }
                    }
                }else{
                    $data['status'] = false;
                    $data['message'] = "order not found";
                }

            }
        }else{
            $data['status'] = false;
            $data['message'] = "invalid copon";
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
            $data['message'] = "shipping address error";
            return $data;
        }

        if ($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }
        
        $id =$request->id;
        $shippingType =$request->shippingType;
        $paymentMethod =$request->paymentMethod;
        $addedTax =$request->addedTax;
        $shippingValue =$request->shippingValue;
        $sub_total =$request->sub_total;
        $total =$request->total;
        $shippingAddress_id =$request->shippingAddress_id;

        Order::where('id',$id)->update([
            "status" => "confirmed",
            "shippingType" => $shippingType,
            "paymentMethod" => $paymentMethod,
            "addedTax" => $addedTax,
            "shippingValue" => $shippingValue,
            "total" => $total,
            "sub_total" => $sub_total,
            "shippingAddress_id" => $shippingAddress_id,
        ]);


        $data['status']=true;
        $data['message'] = "order confirmed";

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
            'item_id' => 'required',
            'item_back_count' => 'required',
            'reason_id' => 'required',
        ]);

        $info['user_id'] = $user->id;
        Item_back_request::create($info);

        $data['status'] = true;
        $data['message'] = 'request item back sent';
        return $data;
    }



    public function itemsCanBack(Request $request){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$request->header('device-id'))->first();
        }

        $lang = $request->header('accept-language');

        $orders = Order::where(['user_id'=>$user->id,'status'=>'completed'])->whereDate('created_at','>=',Carbon::now()->subDays(15))->pluck('id');
        $orders = array_unique($orders->toArray());

        
        $orderItems = Order_item::whereIn('order_id',$orders)->whereDate('created_at','>=',Carbon::now()->subDays(15))->get();

        $data['status'] = true;
        $data['message'] = "Products cannot be returned after 14 days from the date of purchase";


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
            $data['message'] = 'updated to '. $status;
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }

        return $data;
    }





}
