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

    Route::resource('groups', 'GroupController')->except([
        'create', 'edit'
    ]);

    Route::resource('users', 'UserController')->except([
        'create', 'edit'
    ]);

    Route::resource('doctors', 'DoctorController')->except([
        'create', 'edit'
    ]);

    Route::resource('patients', 'PatientController')->except([
        'create', 'edit'
    ]);

    Route::resource('employees', 'EmployeeController')->except([
        'create', 'edit'
    ]);
    
});
