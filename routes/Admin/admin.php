<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){

	//unauth routes
	Route::get('login','Admins@login');
	Route::post('doLogin','Admins@doLogin');


	//lang
	Route::get('lang/{locale}', function ($locale) {
		Session::put('locale',$locale);
	    return redirect('admin/');
	});


	Route::group(['middleware'=>'lang'],function(){
		//auth routes
		Route::group(['middleware'=>"admin:admin"],function(){
			Config::set('auth.defines','admin');

			//dashboard
			Route::get('/','Admins@dashboard');

			//admin
			Route::get('adminInfo','Admins@adminInfo');
			Route::get('viewCreateAdmin/{id?}','Admins@viewCreateAdmin');
			Route::post('createAdmin','Admins@createAdmin');
			Route::get('deleteAdmin/{id?}','Admins@deleteAdmin');
			Route::get('logOut','Admins@logOut');


			//categories
			Route::get('categoriesInfo','Categories@categoriesInfo');
			Route::get('viewCreateCategory','Categories@viewCreateCategory');
			Route::post('createcategory','Categories@createcategory');





		});
	});
});






