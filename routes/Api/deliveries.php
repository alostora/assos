<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;







Route::group(['namespace'=>'Api\Deliveries','middleware'=>'lang'],function(){


	//Auth Routes
    Route::group(['middleware'=>'auth_delivery'],function(){

        Route::get('deliveryProfile','Delivery_auth@profile');
        Route::post('updateDeliveryProfile','Delivery_auth@updateProfile');
        Route::post('changeDeliveryPassword','Delivery_auth@changePassword');
        Route::any('deliveryLogOut','Delivery_auth@logOut');


        //orders
        Route::get('deliveryOrders','Delivery_auth@deliveryOrders');
        Route::get('changeOrderStatus/{orderStatus}/{orderId}','Delivery_auth@changeOrderStatus');

    });



});



