<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
* Rest API Request , auth  & Route
*/ 
Route::group(['prefix' => 'api/v1'], function()
{   
    Route::group(['middleware' => 'api'], function () {
        Route::match(['post','get'],'register','ApiController@register');  
        Route::match(['post','get'],'login', 'ApiController@login'); 
        Route::match(['post','get'],'email_verification','APIController@emailVerification');  
        Route::match(['post','get'],'forget_password','ApiController@forgetPassword'); 
        Route::match(['post','get'],'validate_user','ApiController@validateUser');
        Route::match(['post','get'],'update_profile','ApiController@updateProfile');
        Route::group(['middleware' => 'jwt-auth'], function () 
        { 
           Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
           Route::match(['post','get'],'logout','ApiController@logout'); 
           Route::match(['post','get'],'change_password','ApiController@changePassword');
           Route::match(['post','get'],'get_interviewer','ApiController@getInterviewer');
           Route::match(['post','get'],'add_interview','ApiController@addInterview');
           Route::match(['post','get'],'get_user_details','ApiController@getUserDetails');
        });            
            
    });
});    

/*
* Admin Based Auth
*/  
  

Route::get('/login','Adminauth\AuthController@showLoginForm'); 
Route::post('password/reset','Adminauth\AuthController@resetPassword'); 
   

    

    