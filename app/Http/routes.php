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
        Route::match(['get','post'],'join_evaluation','APIController@joinEvaluation');
        Route::match(['get','post'],'invite_user','APIController@InviteUser');
        Route::match(['get','post'],'get_condidate_record2','APIController@get_condidate_record');
        

        Route::match(['get','post'],'save_evaluation','APIController@saveEvaluation');
        Route::match(['get','post'],'register', 'APIController@register');  
        Route::match(['post','get'],'login', 'APIController@login'); 
        Route::match(['post','get'],'email_verification','APIController@emailVerification');  
        Route::match(['post','get'],'add_position','APIController@addPosition');
        Route::match(['post','get'],'forget_password','APIController@forgetPassword'); 
        Route::match(['post','get'],'validate_user','APIController@validateUser');
        Route::match(['post','get'],'update_profile','APIController@updateProfile');
       //Route::match(['post','get'],'get_directory','APIController@getDirectory');
       // Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
        Route::match(['post','get'],'get_position','APIController@getPosition'); 
        // Token based authentication 
        //Route::match(['post','get'],'get_recent_record','APIController@getRecentCondidateRecord'); 
        Route::match(['post','get'],'get_recent_record','APIController@getRecentRecord'); 
        Route::group(['middleware' => 'jwt-auth'], function () 
        { 
           Route::match(['post','get'],'get_directory','APIController@getDirectory');
          // Route::match(['post','get'],'get_recent_record','APIController@getRecentRecord'); 
           Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
           Route::match(['post','get'],'logout','APIController@logout'); 
           Route::match(['post','get'],'change_password','APIController@changePassword');
           Route::match(['post','get'],'get_interviewer','APIController@getInterviewer');
           Route::match(['post','get'],'add_interview','APIController@addInterview');
           Route::match(['post','get'],'get_criteria','APIController@getCriteria'); 
           Route::match(['post','get'],'add_criteria','APIController@addCriteria'); 
           Route::match(['post','get'],'get_user_details','APIController@getUserDetails');
        });            
            
    });
});    

/*
* Admin Based Auth
*/  
  
 
    Route::get('/login','Adminauth\AuthController@showLoginForm'); 
    Route::post('password/reset','Adminauth\AuthController@resetPassword'); 
   

    

    