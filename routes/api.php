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

Route::group(['middleware' => ['cors', 'api']], function () {

    Route::post('/register', 'AuthController@register');

    Route::post('/login', 'AuthController@login');

    Route::post('/logout', 'AuthController@logout');

    Route::prefix('groups')->group(function () {

        Route::get('/', 'GroupController@index');

        Route::get('/{id}', 'GroupController@show');

        Route::post('/', 'GroupController@store');

        Route::put('/{id}', 'GroupController@update');

        Route::delete('/{id}', 'GroupController@destroy');
    });

    Route::prefix('users')->group(function () {

        Route::get('/', 'UserController@index');

        Route::get('/{id}', 'UserController@show');

        Route::post('/', 'UserController@store');

        Route::put('/{id}', 'UserController@update');

        Route::delete('/{id}', 'UserController@destroy');
    });

    Route::prefix('doctors')->group(function () {

        Route::get('/', 'DoctorController@index');

        Route::get('/{id}', 'DoctorController@show');

        Route::post('/', 'DoctorController@store');

        Route::put('/{id}', 'DoctorController@update');

        Route::delete('/{id}', 'DoctorController@destroy');
    });

    Route::prefix('patients')->group(function () {

        Route::get('/', 'PatientController@index');

        Route::get('/{id}', 'PatientController@show');

        Route::post('/', 'PatientController@store');

        Route::put('/{id}', 'PatientController@update');

        Route::delete('/{id}', 'PatientController@destroy');
    });


    Route::prefix('employees')->group(function () {

        Route::get('/', 'EmployeeController@index');

        Route::get('/{id}', 'EmployeeController@show');

        Route::post('/', 'EmployeeController@store');

        Route::put('/{id}', 'EmployeeController@update');

        Route::delete('/{id}', 'EmployeeController@destroy');
    });
    
});
