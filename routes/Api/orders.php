<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['namespace'=>'Api\Users'],function(){
    
    //Auth Routes
    Route::group(['middleware'=>'auth_user_api'],function(){
        
        //Users_auth_actions
        Route::get('test','Users_auth_actions@test');
    });


    /*un auth routes*/
    //user orders
    Route::post('makeOrder','Orders@makeOrder');
    Route::get('getOrder','Orders@getOrder');



    Route::get('changeItemCount/{orderId}/{type}','Orders@changeItemCount');

    

});
