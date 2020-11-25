<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], 'login', 'AuthenticationController@login')->name('login')->middleware('guest', 'auto_reset_queue');

Route::middleware(['auth'])->group(function(){
	Route::get('/', 'QueuingController@showViewOptions')->middleware('auto_reset_queue');
	Route::get('window', 'QueuingController@showWindowView')->middleware('auto_reset_queue', 'redirect_if_admin');
	Route::get('client/{queue_type}', 'QueuingController@showClientView')->middleware('not_own_queue_type');

	Route::post('increment', 'QueuingController@incrementNumber');

	Route::get('stats', 'QueuingController@getStatistics');

	Route::match(['get', 'put'], 'reset', 'QueuingController@resetQueue')->middleware('redirect_if_not_admin');

	Route::match(['get', 'post'], 'users', 'UserController@index')->middleware('redirect_if_not_admin');
	Route::match(['get', 'put'], 'users/{user}', 'UserController@editUser')->middleware('redirect_if_not_admin');
	Route::delete('users/{user}', 'UserController@removeUser')->middleware('redirect_if_not_admin');

	Route::get('pictures/{user}', 'UserController@getPicture');

	Route::post('logout', 'AuthenticationController@logout');
});