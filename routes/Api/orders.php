<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace'=>'Api\Users'],function(){
    
    //Auth Routes
    


    
    //user orders
    Route::post('makeOrder','Orders@makeOrder');
    
    Route::get('getOrder','Orders@getOrder');



    Route::get('changeItemCount/{orderId}/{type}','Orders@changeItemCount');

    

});
