<?php
use App\Specialist;
use App\Address;
use App\Http\Resources\MyResource;
use App\Http\Resources\DoctorCollection;
use App\Doctor;
use App\Http\Resources\MyCollection;
use App\Http\Resources\RatingCollection;
use App\Rating;

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

    Route::put('/reset-password', 'ResetPasswordController@reset');

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


    Route::resource('questions', 'QuestionController')->except([
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

    Route::get('doctors-pagination', function () {
        return new DoctorCollection(Doctor::with('address', 'specialist', 'sub_specialist', 'employee', 'ratings')->where('actived', '=', 1)->orderBy('id', 'asc')->paginate(10));
    });

    Route::prefix('/patients')->group(function () {
        Route::post('/search', 'SearchController@searchPatient');
    });

    Route::get('/ratings/reported', function () {
        return new RatingCollection(Rating::where('report', '=', 1)->orderBy('id', 'asc')->get());
    });
    Route::prefix('/employees')->group(function () {
        Route::post('/search', 'SearchController@searchEmployee');
    });

    Route::post('/search', 'SearchController@search');
});
