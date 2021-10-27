<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'vendor'],function(){
    Route::group(['namespace' =>'Vendors'],function(){


        //unauth routes
        Route::get('login','Vendors@login');
        Route::post('doLogin','Vendors@doLogin');

        //lang
        Route::get('lang/{locale}', function ($locale) {
            Session::put('locale',$locale);
            return back();
        });


        Route::group(['middleware'=>'lang'],function(){
            Route::group(['middleware'=>"vendor:vendor"],function(){

                //auth routes
                Route::get('/','Vendors@dashBoard');
                Route::get('viewCreateItem','Vendors@viewCreateItem');
                Route::get('itemsInfo','Vendors@itemsInfo');
                Route::post('createItem','Vendors@createItem');


                Route::any('logOut','Vendors@logOut');

            });
        });
    });
});

