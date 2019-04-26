<?php
use App\Specialist;
use App\Address;
use App\Http\Resources\MyResource;

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

    Route::resource('doctors.certificates', 'DoctorCertificateController')->except([
        'create', 'edit'
    ]);


    Route::resource('doctors.ratings', 'RatingDoctorController')->except([
        'create', 'edit'
    ]);


    Route::resource('admins', 'AdminController')->except([
        'create', 'edit'
    ]);

    Route::get('addresses', function () {
        return new MyResource(Address::all());
    });

    Route::get('specialists', function () {
        return new MyResource(Specialist::all());
    });
});
