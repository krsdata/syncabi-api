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
        Route::match(['post','get'],'user/register','ApiController@register');  
        Route::match(['post','get'],'user/updateProfile/{user_id}','ApiController@updateProfile'); 
        Route::match(['post','get'],'user/login', 'ApiController@login'); 
        Route::match(['post','get'],'email_verification','ApiController@emailVerification');  
        Route::match(['post','get'],'forget_password','ApiController@forgetPassword'); 
        Route::match(['post','get'],'validate_user','ApiController@validateUser');
        Route::group(['middleware' => 'jwt-auth'], function () 
        { 
           Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
           Route::match(['post','get'],'user/logout','ApiController@logout'); 
           Route::match(['post','get'],'change_password','ApiController@changePassword');
           Route::match(['post','get'],'get_interviewer','ApiController@getInterviewer');
           Route::match(['post','get'],'add_interview','ApiController@addInterview');
           Route::match(['post','get'],'user/details','ApiController@getUserDetails');
        });   


          /*---------End---------*/   
 
        /*-------------Course API Route -------------*/

        Route::match(['post','get'],'course',[
            'as' => 'course',
            'uses' => 'CourseController@index'
            ]
        );

      
        Route::match(['post','get'],'course/create',[
            'as' => 'course.create',
            'uses' => 'CourseController@create'
            ]
        );
        Route::match(['post','get'],'course/edit',[
            'as' => 'course.edit',
            'uses' => 'CourseController@edit'
            ]
        );

        Route::match(['post','get'],'course/update',[
            'as' => 'course.update',
            'uses' => 'CourseController@update'
            ]
        );

         Route::match(['post','get'],'course/store',[
            'as' => 'course.store',
            'uses' => 'CourseController@store'
            ]
        );
 
        /*-------------Course API Route END-------------*/


        /*-------------Syllabus API Route -------------*/

        Route::match(['post','get'],'syllabus',[
            'as' => 'syllabus',
            'uses' => 'SyllabusController@index'
            ]
        );

      
        Route::match(['post','get'],'syllabus/create',[
            'as' => 'syllabus.create',
            'uses' => 'SyllabusController@create'
            ]
        );

        Route::match(['post','get'],'syllabus/edit',[
            'as' => 'syllabus.edit',
            'uses' => 'SyllabusController@edit'
            ]
        );

        Route::match(['post','get'],'syllabus/update',[
            'as' => 'syllabus.update',
            'uses' => 'SyllabusController@update'
            ]
        );

         Route::match(['post','get'],'syllabus/store',[
            'as' => 'syllabus.store',
            'uses' => 'SyllabusController@store'
            ]
        );
 
        /*-------------Syllabus API Route END-------------*/


        /*-------------Assignment API Route -------------*/

        Route::match(['post','get'],'assignment',[
            'as' => 'assignment',
            'uses' => 'AssignmentController@index'
            ]
        ); 
      
        Route::match(['post','get'],'assignment/create',[
            'as' => 'assignment.create',
            'uses' => 'AssignmentController@create'
            ]
        );
        
        Route::match(['post','get'],'assignment/edit',[
            'as' => 'assignment.edit',
            'uses' => 'AssignmentController@edit'
            ]
        );

        Route::match(['post','get'],'assignment/update',[
            'as' => 'assignment.update',
            'uses' => 'AssignmentController@update'
            ]
        );

         Route::match(['post','get'],'syllabus/store',[
            'as' => 'assignment.store',
            'uses' => 'AssignmentController@store'
            ]
        );
 
        /*-------------Syllabus API Route END-------------*/

        
            
    });
});    

/*
* Admin Based Auth
*/  
  

Route::get('/login','Adminauth\AuthController@showLoginForm'); 
Route::post('password/reset','Adminauth\AuthController@resetPassword'); 