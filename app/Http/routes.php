<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('files', function(){
	foreach (glob(storage_path().'/uploads/pcount/*.*') as $filename) {
	    echo "$filename size " . filesize($filename) . "\n";
	}
});

Route::get("/", "DashboardController@index");

Route::resource('dashboard', 'DashboardController');

Route::resource('area', 'AreaController');

Route::resource('brand', 'BrandController');

Route::resource('category', 'CategoryController');

Route::resource('customer', 'CustomerController');

Route::resource('division', 'DivisionController');

Route::resource('premise', 'PremiseController');

Route::resource('store', 'StoreController');

Route::resource('sku', 'SkuController');

Route::group(array('prefix' => 'api'), function()
{
	Route::get('auth', 'Api\AuthUserController@auth');
   	Route::get('download', 'Api\DownloadController@index');
   	Route::post('uploadpcount', 'Api\UploadController@uploadpcount');
   	
});//
