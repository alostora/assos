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
use Auth;
use URL;

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
                        "total_price" => $itemPrice
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

        if(!empty($user)){
            $order = Order::where(['user_id'=>$user->id,'status' => "new"])
                    ->with(['order_items'=>function($query){
                        $query->with('order_items_props');
                    }])->first();

            if(!empty($order)){
                if(count($order->order_items)){
                    foreach($order->order_items as $orderItem){
                        $item = Item::find($orderItem->item_id);
                        if(!empty($item)) {
                            $orderItem->itemName = $request->header('accept-language') != 'ar' ? $item->itemName : $item->itemNameAr;
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
                                            $itemProp->propertyName = $request->header('accept-language') != 'ar' ? $itemSubProp->propertyName : $itemSubProp->propertyNameAr;

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
        }
        $data['status'] = true;
        $data['order'] = $order;

        return $data;
    }






    public function deleteOrderItem($itemId){
        
        $orderItem = Order_item::where('id',$itemId)->first();
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
                        $order->total_price = $itemPrice - $order->total_price;
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






}
