<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Auth,Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use JWTExceptionTokenInvalidException; 
use App\Helpers\Helper as Helper;
use App\User;
use App\ProfessorProfile;
use App\StudentProfile;



class ApiController extends Controller
{
    
   /* @method : validateUser
    * @param : email,password,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */

    public function __construct(Request $request) {

        if ($request->header('Content-Type') != "application/json")  {
            $request->headers->set('Content-Type', 'application/json');
        }
        $user_id =  $request->input('userID');
       
    } 
    
   /* @method : register
    * @param : email,password,deviceID,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */

    public function register(Request $request,User $user)
    {   
        $input['name']         = $request->input('name');
        $input['email']        = $request->input('email'); 
        $input['role_type']    = $request->input('roleType');  
        $input['password']     = Hash::make($request->input('password'));
        
        if($request->input('userID')){
            $u = $this->updateProfile($request,$user);
            return $u;
        } 

        //Server side valiation
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'name'  => 'required',
           'password' => 'required',
           'roleType' => 'required'

        ]);
         /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'code'   => 500,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }  
        $roleType   = $request->input('roleType');
        if($roleType==1){
       
           $professor  = User::where('email',$request->input('email'))
                        ->where('role_type',1)->first();
            if(count($professor)){
                $status     = 0;
                $code       = 500;
                $message    = "Email id already exist!";
                $data       = $request->get('email');
            }else{
                $user = User::create($input);
                $professor =  ProfessorProfile::firstOrNew(['professor_id' => $user->id]);
                $professor->name            = $request->get('name');   
                $professor->designation     = $request->get('designation');   
                $professor->office_hours    = $request->get('office_hours');   
                $professor->location        = $request->get('location');   
                $professor->email           = $request->get('email');   
                $professor->professor_id    = $user->id;   
                $professor->save();
                $data = ['userId'=>$user->id,'name'=>$user->name,'email'=>$user->email];
                $data['roleType'] = "professor";
                $status = 1;
                $code   = 200;
                $message = "Registration successfully done."; 
            } 
        }
        if($roleType==2){  
            $student    = User::where('email',$request->input('email'))
                        ->where('role_type',2)->first();

            if(count($student)){
                $status     = 0;
                $code       = 500;
                $message    = "Email id already exist!";
                $data       = $request->get('email');
            }else{
                $user = User::create($input);
                $student =  StudentProfile::firstOrNew(['student_id' => $user->id]);
                $student->student_id    = $user->id;
                $student->name          = $request->get('name');
                $student->email         = $request->get('email');
                $student->phone         = $request->get('phone');
                $student->address       = $request->get('address');
                $student->save();
                $data = ['userId'=>$user->id,'name'=>$user->name,'email'=>$user->email];
                $data['roleType'] = "student"; 
                $status = 1;
                $code   = 200;
                $message = "Registration successfully done."; 
            } 
        } 

        /*      
            helper = new Helper;
            $subject = "Welcome to syncabi! Verify your email address to get started";
            $email_content = array('receipent_email'=> $user->email,'subject'=>'subject');
            $verification_email = $helper->sendMailFrontEnd($email_content,'verification_link',['name'=> 'fname']);
        */
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$data
                            ]
                        );
    }

/* @method : update User Profile
    * @param : email,password,deviceID,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */
    public function updateProfile(Request $request,User $user,$user_id=null)
    {       
        if(!Helper::isUserExist($user_id))
        {
            return Response::json(array(
                'status' => 0,
                'message' => 'Invalid user ID!',
                'data'  =>  ''
                )
            );
        } 
        $user = User::find($user_id); 
        $role_type  = $user->role_type;

        $data = ['userID'=>$user->id,'name'=>$user->name,'email'=>$user->email];
        if($user->role_type==1){
            $data =  ProfessorProfile::firstOrNew(['professor_id' => $user->id]);
            $data->name            = $request->get('name');   
            $data->designation     = $request->get('designation');   
            $data->office_hours    = $request->get('office_hours');   
            $data->location        = $request->get('location');   
            $data->email           = $request->get('email');   
            $data->professor_id    = $user->id;   
        }
        if($user->role_type==2){
            $data =  StudentProfile::firstOrNew(['student_id' => $user->id]);
            $data->student_id    = $user->id;
            $data->name          = $request->get('name');
            $data->email         = $request->get('email');
            $data->phone         = $request->get('phone');
            $data->address       = $request->get('address');
        } 

        return response()->json(
                            [ 
                            "status"=>1,
                            'code'   => 200,
                            "message"=> "Profile updated successfully",
                            'data'=>$data
                            ]
                        );
         
    }

   /* @method : login
    * @param : email,password and deviceID
    * Response : json
    * Return : token and user details
    * Author : kundan Roy   
    */
    public function login(Request $request)
    {    
        $input = $request->all();
        if (!$token = JWTAuth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')])) {
            return response()->json([ "status"=>0,"message"=>"Invalid email or password. Try again!" ,'data' => '' ]);
        }

        $user = JWTAuth::toUser($token); 

        $data['userId']         = $user->id;
        $data['name']           = $user->name; 
        $data['email']          = $user->email;
        $data['roleType']       = ($user->role_type==1)?"professor":"student";
        $data['token']          = $token;

        if($user->status)
        {
           // return response()->json([ "status"=>0,"message"=>"Your email is not verified!" ,'data' => '' ]);   
        }
 
        return response()->json([ "status"=>1,"code"=>200,"message"=>"Successfully logged in." ,'data' => $data ]);

    } 
   /* @method : get user details
    * @param : Token and deviceID
    * Response : json
    * Return : User details 
   */
   
    public function getUserDetails(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        $data = [];
        $data['userId']         = $user->id;
        $data['name']           = $user->name;
        $data['email']          = $user->email;
        $data['roleType']       = ($user->role_type==1)?"professor":"student";
       
        if($user->role_type==1){
            $professor =  ProfessorProfile::where(['professor_id' => $user->id])->first();
            if($professor){
                $data['designation']    = $professor->designation;
                $data['office_hours']   =  $professor->office_hours;  
                $data['location']       = $professor->location;
                $data['professor_id']  = $professor->professor_id;  
            } 
        }
        if($user->role_type==2){
            $student =  StudentProfile::where(['student_id' => $user->id])->first();
            if($student){
                $data['student_id'] = $student->student_id;
                $data['phone']      = $student->phone;
                $data['address']    = $student->address;
            }
        }  

        return response()->json(
                [ "status"=>1,
                  "code"=>200,
                  "message"=>"Record found successfully." ,
                  "data" => $data 
                ]
            ); 
    }
   /* @method : Email Verification
    * @param : token_id
    * Response : json
    * Return :token and email 
   */
   
    public function emailVerification(Request $request)
    {
        $verification_code = $request->input('verification_code');
        $email    = $request->input('email');

        if (Hash::check($email, $verification_code)) {
           $user = User::where('email',$email)->get()->count();
           if($user>0)
           {
              User::where('email',$email)->update(['status'=>1]);  
           }else{
            echo "Verification link is Invalid or expire!"; exit();
                return response()->json([ "status"=>0,"message"=>"Verification link is Invalid!" ,'data' => '']);
           }
           echo "Email verified successfully."; exit();  
           return response()->json([ "status"=>1,"message"=>"Email verified successfully." ,'data' => '']);
        }else{
            echo "Verification link is Invalid!"; exit();
            return response()->json([ "status"=>0,"message"=>"Verification link is invalid!" ,'data' => '']);
        }
    }
   
   /* @method : logout
    * @param : token
    * Response : "logout message"
    * Return : json response 
   */
    public function logout(Request $request)
    {   
        $token = $request->input('token');
         
        JWTAuth::invalidate($request->input('token'));

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've successfully signed out.",
                    'data' => ""
                    ]
                );
    }
   /* @method : forget password
    * @param : token,email
    * Response : json
    * Return : json response 
    */
    public function forgetPassword(Request $request)
    {   
        $email = $request->input('email');
        //Server side valiation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        $helper = new Helper;
       
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

        $user =   User::where('email',$email)->get();

        if($user->count()==0){
            return Response::json(array(
                'status' => 0,
                'message' => "Oh no! The address you provided isn't in our system",
                'data'  =>  ''
                )
            );
        }
        $user_data = User::find($user[0]->userID);
        $temp_password = Hash::make($email);
       
        
      // Send Mail after forget password
        $temp_password =  Hash::make($email);
 
        $email_content = array(
                        'receipent_email'   => $request->input('email'),
                        'subject'           => 'Your Account Password',
                        'name'              => $user[0]->first_name,
                        'temp_password'     => $temp_password,
                        'encrypt_key'       => Crypt::encrypt($email)
                    );
        $helper = new Helper;
        $email_response = $helper->sendMail(
                                $email_content,
                                'forgot_password_link'
                            ); 
       
       return   response()->json(
                    [ 
                        "status"=>1,
                        "code"=> 200,
                        "message"=>"Reset password link has sent. Please check your email.",
                        'data' => ''
                    ]
                );
    }

   /* @method : change password
    * @param : token,oldpassword, newpassword
    * Response : "message"
    * Return : json response 
   */
    public function changePassword(Request $request)
    {   
        $user = JWTAuth::toUser($request->input('deviceToken'));
        $user_id = $user->userID; 
        $old_password = $user->password;
     
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6'
        ]);
        // Return Error Message
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

         
        if (Hash::check($request->input('oldPassword'),$old_password)) {

           $user_data =  User::find($user_id);
           $user_data->password =  Hash::make($request->input('newPassword'));
           $user_data->save();
           return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Password changed successfully.",
                    'data' => ""
                    ]
                );
        }else
        {
            return Response::json(array(
                'status' => 0,
                'message' => "Old password mismatch!",
                'data'  =>  ''
                )
            );
        }         
    }
 
    /*SORTING*/
    public function array_msort($array, $cols)
    {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}
   /* @method : Get Condidate rating
    * @param : Interviewer ID
    * Response : json
    * Return :   getCondidateRecord
    */
    public function get_condidate_record(Request $request, Interview $interview)
    {   
        $condidate_id   =  $request->input('directoryID');
        $condidate_name =  Helper::getCondidateNameByID($condidate_id);
        if($condidate_name==null){
            return  json_encode(
                        [  
                            "status"=>0,
                            "code"=> 404,
                            "message"=>"Record not found", 
                            'data' => ""
                        ] 
                    );  
        }
        $interview_data     =  InterviewRating::where('condidateID',$condidate_id)->get();
        $interview_details  = [];
        $c_details          = Interview::find($condidate_id);
        $interviewerComment = [];
        $date           = \Carbon\Carbon::parse($c_details->created_at)->format('m/d/Y');
       /* $date_diff      = \Carbon\Carbon::parse('27-07-2016')->diffForHumans();  
        $is_tomorrow    = \Carbon\Carbon::parse('28-07-2016')->isTomorrow();
        $is_today       = \Carbon\Carbon::parse('28-07-2016')->isTomorrow();
       */
        if($interview_data->count()>0){
            $interview_criteriaID =[];
            foreach ($interview_data as $key => $result) {

                $rating_value    = str_getcsv($result->rating_value);
                $interviewerName = Helper::getUserDetails($result->interviewerID);
                
                if( !empty($result->comment))
                {
                  $interviewerComment[]  =[
                            'firstName' => $interviewerName['firstName'],
                            'lastName'  => $interviewerName['lastName'],
                            'comment'   => $result->comment];
                }    
                
                $interview_details[]   =  Helper::getCriteriaById(str_getcsv($result->interview_criteriaID),$rating_value,$interviewerName,$result->comment); 
                 
            }
        }else{ 
             return  response()->json([  
                            "status"=>1,
                            "code"=> 200,
                            "message"=>"Record found successfully.",  
                            "data"  =>  array(
                                "date"=>$date,
                                "details"=>$interview_details,
                                "comment"=>$interviewerComment,
                                ) 
                        ] 
                    );  
        } 
        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200, 
                    "message"=>"Record found successfully.",  
                    "data"  =>  array(
                        "date"=>$date,
                        "details"=>$interview_details,
                        "comment"=>$interviewerComment,
                        )  
                    ]    
                );  

         // "comment" => $comment,
                               // "ratingDetail"=>$interview_details]
    }
 
  
    public function InviteUser(Request $request,InviteUser $inviteUser)
    {   
        $user =   $inviteUser->fill($request->all()); 
       
        $user_id = $request->input('userID'); 
        $invited_user = User::find($user_id); 
        
        $user_first_name = $invited_user->first_name ;
        $download_link = "http://google.com";
        $user_email = $request->input('email');

        $helper = new Helper;
        $cUrl =$helper->getCompanyUrl($user_email);
        $user->company_url = $cUrl; 
        /** --Send Mail after Sign Up-- **/
        
        $user_data     = User::find($user_id); 
        $sender_name     = $user_data->first_name;
        $invited_by    = $invited_user->first_name.' '.$invited_user->last_name;
        $receipent_name = "User";
        $subject       = ucfirst($sender_name)." has invited you to join";   
        $email_content = array('receipent_email'=> $user_email,'subject'=>$subject,'name'=>'User','invite_by'=>$invited_by,'receipent_name'=>ucwords($receipent_name));
        $helper = new Helper;
        $invite_notification_mail = $helper->sendNotificationMail($email_content,'invite_notification_mail',['name'=> 'User']);
        $user->save();

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've invited your colleague, nice work!",
                    'data' => ['receipentEmail'=>$user_email]
                   ]
                );

    }
    
} 