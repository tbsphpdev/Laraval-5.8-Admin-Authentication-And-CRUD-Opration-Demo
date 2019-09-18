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

Route::get('/', function () {
    return view('login');
})->name('main');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::group(['middleware' => 'auth'], function(){
Route::get('/home', 'HomeController@index')->name('home');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
 Route::group(['prefix'=>'user'],function (){
        Route::get('user', 'UserController@index');
        Route::post('list', 'UserController@userlist'); 
        Route::get('user-view/{id}','UserController@user_details');
        Route::post('add-user', 'UserController@addUser');
        Route::view('welcome','welcome');
        Route::get('change-userstatus/{id}/{status}', 'UserController@changeuserStatus');
        Route::get('edit-user/{id}', 'UserController@getByid');
        Route::get('delete/{id}', 'UserController@delete_user');
    });
    Route::group(['prefix'=>'content'],function (){
    	Route::get('content', 'ContentController@index');
        Route::post('list', 'ContentController@UserGuidelist');
    	Route::post('add-content', 'ContentController@addContent');
    	Route::get('edit-content/{id}', 'ContentController@getByid');
        Route::get('delete-userguide/{id}', 'ContentController@delete_userguide');
    });
});


