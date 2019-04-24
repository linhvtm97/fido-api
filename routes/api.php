<?php
use App\Specialist;
use App\Http\Resources\MyCollection;

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
<<<<<<< HEAD

    Route::resource('doctors.certificates', 'DoctorsCertificatesController')->except([
=======
   
    Route::resource('admins', 'AdminController')->except([
>>>>>>> 7c129d16d4e779032e77e910b11360742f318536
        'create', 'edit'
    ]);
    
});
