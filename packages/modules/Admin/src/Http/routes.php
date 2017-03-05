<?php
      Route::get('admin/login','Modules\Admin\Http\Controllers\AuthController@index');
      Route::get('admin/forgot-password','Modules\Admin\Http\Controllers\AuthController@forgetPassword');
      Route::post('password/email','Modules\Admin\Http\Controllers\AuthController@sendResetPasswordLink');
      Route::get('admin/password/reset','Modules\Admin\Http\Controllers\AuthController@resetPassword');  
      Route::get('logout','Modules\Admin\Http\Controllers\AuthController@logout');  
        
      Route::post('admin/login',function(App\Admin $user){
       
        $credentials = ['email' => Input::get('email'), 'password' => Input::get('password')]; 
        
       // $credentials = ['email' => 'kundan@gmail.com', 'password' => 123456]; 
        $auth = auth()->guard('admin');
        

            if ($auth->attempt($credentials)) {
                return Redirect::to('admin');
            }else{ 
               //return Redirect::to('admin/login')->withError(['message'=>'Invalid Credential!']);
                return redirect()
                            ->back()
                            ->withInput()  
                            ->withErrors(['message'=>'Invalid email or password. Try again!']);
                } 
        }); 
      
    Route::group(['middleware' => ['admin']], function () { 

        Route::get('admin', 'Modules\Admin\Http\Controllers\AdminController@index');
        
        /*------------User Model and controller---------*/

        Route::bind('user', function($value, $route) {
            return Modules\Admin\Models\User::find($value);
        });

        Route::resource('admin/user', 'Modules\Admin\Http\Controllers\UsersController', [
            'names' => [
                'edit' => 'user.edit',
                'show' => 'user.show',
                'destroy' => 'user.destroy',
                'update' => 'user.update',
                'store' => 'user.store',
                'index' => 'user',
                'create' => 'user.create',
            ]
                ]
        );
        /*---------End---------*/   

        /*------------Position Model and controller---------*/
        Route::bind('position', function($value, $route) {
            return Modules\Admin\Models\Position::find($value);
        });

        Route::resource('admin/position', 'Modules\Admin\Http\Controllers\PositionController', [
            'names' => [
                'edit' => 'position.edit',
                'show' => 'position.show',
                'destroy' => 'position.destroy',
                'update' => 'position.update',
                'store' => 'position.store',
                'index' => 'position',
                'create' => 'position.create'
            ]
                ]
        );
        /*---------End---------*/  

        /*------------Criteria Model and controller---------*/
        Route::bind('criteria', function($value, $route) {
            return Modules\Admin\Models\Criteria::find($value);
        });

        Route::resource('admin/criteria', 'Modules\Admin\Http\Controllers\CriteriaController', [
            'names' => [
                'edit' => 'criteria.edit',
                'show' => 'criteria.show',
                'destroy' => 'criteria.destroy',
                'update' => 'criteria.update',
                'store' => 'criteria.store',
                'index' => 'criteria',
                'create' => 'criteria.create'
            ]
                ]
        );
        /*----------End---------*/ 

         /*------------Criteria Model and controller---------*/
        Route::bind('corporateProfile', function($value, $route) {
            return Modules\Admin\Models\CorporateProfile::find($value);
        });

        Route::resource('admin/corporateProfile', 'Modules\Admin\Http\Controllers\CorporateProfileController', [
            'names' => [
                'edit' => 'corporateProfile.edit',
                'show' => 'corporateProfile.show',
                'destroy' => 'corporateProfile.destroy',
                'update' => 'corporateProfile.update',
                'store' => 'corporateProfile.store',
                'index' => 'corporateProfile',
                'create' => 'corporateProfile.create'
            ]
                ]
        );
        
         /*------------ratingFeedback Model and controller---------*/
        Route::bind('ratingFeedback', function($value, $route) {
            return Modules\Admin\Models\RatingFeedback::find($value);
        });

        Route::resource('admin/ratingFeedback', 'Modules\Admin\Http\Controllers\RatingFeedbackController', [
            'names' => [
                'edit' => 'ratingFeedback.edit',
                'show' => 'ratingFeedback.show',
                'destroy' => 'ratingFeedback.destroy',
                'update' => 'ratingFeedback.update',
                'store' => 'ratingFeedback.store',
                'index' => 'ratingFeedback',
                'create' => 'ratingFeedback.create'
            ]
                ]
        );

          /*------------ratingFeedback Model and controller---------*/
        Route::bind('defaultCriteria', function($value, $route) {
            return Modules\Admin\Models\DefaultCriteria::find($value);
        });

        Route::resource('admin/defaultCriteria', 'Modules\Admin\Http\Controllers\DefaultCriteriaController', [
            'names' => [
                'edit' => 'defaultCriteria.edit',
                'show' => 'defaultCriteria.show',
                'destroy' => 'defaultCriteria.destroy',
                'update' => 'defaultCriteria.update',
                'store' => 'defaultCriteria.store',
                'index' => 'defaultCriteria',
                'create' => 'defaultCriteria.create'
            ]
                ]
        );

        Route::get('admin/getDirectory/{id}', 'Modules\Admin\Http\Controllers\InterviewController@index'); 
        Route::resource('admin/getDirectory','Modules\Admin\Http\Controllers\CorporateProfileController@show');
        Route::get('admin/corporateUser/{name}','Modules\Admin\Http\Controllers\CorporateProfileController@corporateUser');
        Route::get('admin/recentInterview/{id}', 'Modules\Admin\Http\Controllers\InterviewController@recentInterview'); 
        Route::get('admin/condidateDirectory', 'Modules\Admin\Http\Controllers\InterviewController@condidateDirectory'); 
        /*----------End---------*/    
        
        Route::match(['get','post'],'admin/profile', 'Modules\Admin\Http\Controllers\AdminController@profile'); 
        
        Route::match(['get','post'],'admin/monthly-report/{name}', 'Modules\Admin\Http\Controllers\MonthlyReportController@corporateUser'); 
        Route::match(['get','post'],'admin/corporate-monthly-report', 'Modules\Admin\Http\Controllers\MonthlyReportController@index'); 
             
  });



 
 
     
 
  