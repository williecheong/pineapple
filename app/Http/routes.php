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

if (env('SHOP_CLOSED')) {
	Route::get('/', 'MainController@closed');
} else {
	Route::get('/', 'MainController@main');
	Route::get('/order', 'MainController@order');
	Route::controller('api', 'ApiController');
}
