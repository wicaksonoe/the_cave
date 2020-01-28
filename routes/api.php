<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
	'prefix' => 'v1',
	'middleware' => 'api'
], function() {
	Route::post('login', 'APIController@login');
	Route::post('register', 'APIController@register');
	Route::get('logout', 'APIController@logout');
	Route::get('home', 'APIController@home');

	Route::group([
		'prefix' => 'barang',
		'middleware' => 'auth:api',
	], function () {
		Route::post('/', 'BarangController@create');	
		Route::get('/', 'BarangController@get');	
		Route::get('/{barcode}', 'BarangController@get');
		Route::put('/{barcode}', 'BarangController@update');
		Route::delete('/{barcode}', 'BarangController@delete');
	});
});
