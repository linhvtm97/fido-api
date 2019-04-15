<?php


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

Route::group(['middleware' => 'cors', 'prefix' => '/v1'], function () {
    Route::post('/login', 'UserController@authenticate');
    Route::post('/register', 'UserController@register');
    Route::get('/logout/{api_token}', 'UserController@logout');
});

Route::get('groups', 'GroupController@index');

Route::get('group/{id}', 'GroupController@show');

Route::post('group', 'GroupController@store');

Route::put('group/{id}', 'GroupController@update');

Route::delete('group/{id}', 'GroupController@destroy');

// users

Route::get('users', 'UserController@index');

Route::get('user/{id}', 'UserController@show');

Route::post('user', 'UserController@store');

Route::put('user/{id}', 'UserController@update');

Route::delete('user/{id}', 'UserController@destroy');