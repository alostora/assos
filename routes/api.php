<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::group(['namespace'=>'Api\Users'],function(){

    Route::post('userCountery','Users_auth@userCountery');
    Route::get('vendors','Users@vendors');
    Route::get('categories/{vendor_id?}','Users@categories');

});
