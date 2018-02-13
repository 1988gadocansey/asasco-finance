<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {
    Auth::routes();
    Route::get('/', function () {
        return view('auth/login');
    })->middleware('guest');
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/dashboard', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/students', 'StudentController@index');
    Route::post('/biodataUpdate', 'StudentController@biodataSave');
    Route::post('/profile/upload', 'PhotoController@uploadPhoto');

    Route::match(array("get", "post"),'/course_registration','CourseController@register');

    Route::get('/printOut/{student}', 'CourseController@printRegistration');
    Route::get('/registeredCourses', 'CourseController@registeredCourses');
    Route::get('/statement_account', 'HomeController@accountStatement');

    Route::get( '/result/transcript/provisonal', "CourseController@transcript");

    Route::get('/liaison/form/attachment', 'LiaisonController@showForm');
    Route::post('/liaison_attachment', 'LiaisonController@processForm');
    Route::get('/liaison/form/attachment/print', 'LiaisonController@printAttachmentForm');


    Route::get('/liaison/form/assumption', 'LiaisonAssumptionController@showForm');
    Route::post('/liaison_assumption', 'LiaisonAssumptionController@processForm');
    Route::get('/liaison/form/assumption/print', 'LiaisonAssumptionController@printAttachmentForm');

    Route::get('lecturer_course', 'QualityAssuranceController@getCourse');
    Route::get('lecturer/assessment', 'QualityAssuranceController@showForm');
    Route::post('lecturer_assessment', 'QualityAssuranceController@processStep1');
    Route::get('lecturer/assessment/print', 'QualityAssuranceController@printForm');
    Route::get('lecturer/assessment/wizzad', 'QualityAssuranceController@showFormWizzard');
    Route::post('lecturer_assessment_wizard', 'QualityAssuranceController@processForm');
    Route::delete('/lecturer_delete', 'QualityAssuranceController@destroy');


//

});
