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
   

    Route::match(array("get", "post"),'/course_registration','CourseController@register');

    Route::get('/pay/fees', 'FeeController@showPayform');
    Route::post('/pay_fees', 'FeeController@showStudent');
    Route::post('/processPayment', 'FeeController@processPayment');

    Route::get('/printreceipt/{receiptno}', 'FeeController@printreceipt');
    Route::get('search/autocomplete', 'SearchController@autocomplete');



    Route::get('/student/owing', 'FeeController@owing');

    Route::get('/student/paid', 'FeeController@index');
    Route::get('transactions/ledger', 'FeeController@masterLedger');



//

});
