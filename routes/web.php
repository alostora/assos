<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('molk');
});


Route::get('molk/{path?}',function(){
    return view('welcome');
})->where('path','.*');

