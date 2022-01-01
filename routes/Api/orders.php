<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace'=>'Api\Users'],function(){
    
    //Auth Routes
    

    //user orders
    Route::post('makeOrder','Orders@makeOrder');
    
    Route::get('getOrder','Orders@getOrder');
    Route::get('deleteItem/{itemId}','Orders@deleteItem');
    Route::get('deleteOrderItem/{itemId}','Orders@deleteOrderItem');
    Route::get('itemCountPlus/{itemId}','Orders@itemCountPlus');
    Route::get('itemCountMinus/{itemId}','Orders@itemCountMinus');
    Route::get('checkOut/{orderId}','Orders@checkOut');
    Route::get('checkOutDetails','Orders@checkOutDetails');


    //order discount copon
    Route::post('orderCopon','Orders@orderCopon');

    //confirm order
    Route::post('confirmOrder','Orders@confirmOrder');

    //item back
    Route::get('itemBackReasons','Orders@itemBackReasons');
    Route::post('itemBackRequest','Orders@itemBackRequest');
    Route::get('getAllOrders','Orders@getAllOrders');
    Route::get('itemsCanBack','Orders@itemsCanBack');


    ///test and well delete
    Route::get('changeOrderStatus/{oderId}/{status}','Orders@changeOrderStatus');





});
