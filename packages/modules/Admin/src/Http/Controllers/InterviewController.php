<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Http\Requests\CorporateProfileRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\CorporateProfile;
use Modules\Admin\Models\Criteria;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use View;
use URL;
use Lang;
use App\Http\Controllers\Controller;
use App\Helpers\Helper as Helper;
use Modules\Admin\Models\Interview;
use Modules\Admin\Models\InterviewRating;
use Carbon;
use DateTime;
use PDF;
use DB;
/**
 * Class AdminController
 */
class InterviewController extends Controller {
    /**
     * @var  Repository
     */
   
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        $this->middleware('admin');
        View::share('viewPage', 'Corporate Profile');
        $this->record_per_page = Config::get('app.record_per_page');
    }
    protected $criteria;
    /*
     * Dashboard
     * */
    public function index($id) 
    {
        
        $condidate_id   =  $id; 
        $condidate_name =  Helper::getCondidateNameByID($condidate_id);
        if($condidate_name==null)
        {
            return  json_encode([  
                            "status"=>0,
                            "code"=> 404,
                            "message"=>"Record not found", 
                            'data' => ""
                        ] 
                    );  
        }
         

        $interview_data =  InterviewRating::where('condidateID',$condidate_id)->get();

         
        $rating = InterviewRating::selectRaw('sum(rating) as total_rating')
                                    ->selectRaw('count(*) as total_user')
                                    ->where('condidateID',$condidate_id)->first(); 
        $rate="0.0";                            
        if($rating->total_user!=0){
          $rate =   $rating->total_rating/$rating->total_user;
        }
        $interview_details = [];
        $c_details =  Interview::find($condidate_id);
        $interviewerComment = [];
        $date = \Carbon\Carbon::parse($c_details->created_at)->format('d/m/Y');
        if($interview_data->count()>0)
        {   $interview_criteriaID =[];
            foreach ($interview_data as $key => $result) {
                $rating_value    = str_getcsv($result->rating_value);
                $interviewerName = Helper::getUserDetails($result->interviewerID);
                if( !empty($result->comment))
                {
                  $interviewerComment[]  = $result->comment;  
                }    
                
                $interview_details[]   =  Helper::getCriteriaById(str_getcsv($result->interview_criteriaID),$rating_value,$interviewerName,$result->comment); 
                 
            }
        }else{ 
             $condidates =   array(
                               "date"=>$date,
                              "details"=>$interview_details,
                              "comment"=>$interviewerComment,
                                );  
        } 
        $condidates =  array(
                        "date"=>$date,
                        "details"=>$interview_details,
                        "comment"=>$interviewerComment,
                        );

                  
        $page_title = "Rating Detail";
        $page_action = "Candidate Detail";
        $rating_detail = $condidates['details'];
        $comment =  $interviewerComment;
       
        return view('packages::corporateProfile.condidate_details', compact('rate','comment','c_details','rating_detail', 'page_title', 'page_action'));
    }

    public function getRecentCondidateRecord(Request $request,Interview $interview)
    {   
       // $user_id = $request->get('userID'); 
        $user_id =  $request->get('userID');
         
        
        if(empty($user_id))
        {
            return  response()->json([ 
                "status"=>0,
                "code"=> 404,
                "message"=>"UserID required!",
                "data"  => ""
               ]
            );
        } 

        $corp_profile       = CorporateProfile::where('userID',$user_id)->get();
        $corp_profile_name  = $corp_profile->lists('company_url','userID');
        if($corp_profile->count()==0)
        {
            return  response()->json([ 
                "status"=>0,
                "code"=> 404,
                "message"=>"Unauthorised access!",
                "data"  => ""
               ]
            );
        } 

        $user_from_same_company = CorporateProfile::where('company_url',$corp_profile_name[$user_id])->get();
        $same_company_id    =   $user_from_same_company->lists('userID');
        $get_interviewer_list = User::whereIn('userID', $user_from_same_company->lists('userID'))
                                     ->where('status',1)->get();
         
        $interview_details = [];

         foreach ($user_from_same_company as $key => $user_record) { 
            $interviewD = Interview::where(function($query) use($user_record){
                $query->whereRaw('FIND_IN_SET('.$user_record->userID.',interviewerID)');
                }
            )
            ->get(); 
            $interview_condidate_data = $interviewD->lists('interviewerID','id'); 
            foreach ($interview_condidate_data as $key => $icd) {   
                $interviewData[$key] = $icd;
            } 
        }    
         ksort($interviewData);
        $interview_details_p=[]; 
        $interview_details_c=[];
        foreach ($interviewData as $cid => $cvalue) {
             
            $interview = Interview::where('id',$cid)->get(); 
            $condidate_detail  =  Helper::getCondidateNameByID($cid);
                 
            foreach ($interview as $key => $condidate) {
                
                $condidate_id   = $condidate->id;
                $int_ids = str_getcsv($condidate->interviewerID);
                $interview_data =  InterviewRating::where('condidateID',$condidate_id )
                                    ->whereIn('interviewerID',$int_ids)
                                    ->get();
                
                //$interview_details_c =[];
                $rate_int_id='';         
                if($interview_data->count()>0)
                {    
                    $interview_criteriaID =[];
                    foreach ($interview_data as $key => $result) {
                        $rate_int_id = $result->interviewerID;
                        $rating_value    = str_getcsv($result->rating_value);
                        $interviewerName = Helper::getUserDetails($result->interviewerID);
                        $interview_details['evaluated'][]   =  Helper::getAllCondidateDetails(str_getcsv($result->interview_criteriaID),$rating_value,$interviewerName,$result->comment); 
                    }
                    
                 }   
                    
                $pending_int_ids = str_getcsv($condidate->interviewerID);
                foreach ($same_company_id as $key => $arrData) {
                       $arr_usedID[] = $arrData;
                }  
                foreach ($pending_int_ids as $key => $pid) {
                    
                    if($pid!=$rate_int_id && (in_array($pid, $arr_usedID)))
                    {
                        if($pid!=null){
                            $interviewerName2 = Helper::getUserDetails($pid);
                            $rating_value    = [];
                            $criteriaIDs = str_getcsv($condidate->criteriaID);
                            $comments = $condidate->comment;
                            $interview_details['pending'][]   =  Helper::getAllCondidateDetails($criteriaIDs,$rating_value,$interviewerName2,$comments); 
                        }
                    } 
                 }
                
            $arr_data[] = ['condidateDetail'=>$condidate_detail, 'result'=>$interview_details];
            }
            $interview_details=[];  
            $rate_int_id =null;    
        }     
       $mine_interview = $this->mineRecentCondidateInterview($user_id,$same_company_id);
        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Record found successfully.",
                    "data"  =>  ['allRecentData'=>$arr_data,'mineRecent'=>$mine_interview]
                   ]
                );  
    } 

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(corporateProfile $corporateProfile) {
      }

    public function update(CriteriaRequest $request, Criteria $criteria) {
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(CorporateProfile $corporateProfile) {

        
    }
    
    /* @method : Get Directory
    * @param : Interviewer ID
    * Response : json
    * Return :  
    */
    public function show(Request $request ,corporateProfile $corporateProfile)
    { 
        $page_title ="Candidate Directory";
        $page_action = "View";

        $corporate_profile  = CorporateProfile::find($corporateProfile->id);
        $user_id = $corporate_profile->userID;

        $is_user_exist = Helper::isUserExist($user_id);
       
        if(!$is_user_exist){
            return  [ 
                    "status"    =>  0,
                    "message"   =>  "Record not found",
                    'data'      =>  ""
                   ]
                 ;
        }
        $corp_profile       = CorporateProfile::where('userID',$user_id)->get();
        $corp_profile_name  = $corp_profile->lists('company_url','userID');


        $user_from_same_company = CorporateProfile::where('company_url',$corp_profile_name[$user_id])->get();
         
        $get_interviewer_list = User::whereIn('userID', $user_from_same_company->lists('userID'))
                                     ->where('status',1)->get();
        $condidate=[];
        foreach ($get_interviewer_list as $key => $value) {
          $search =  $request->get('search');
          $uid = $value->userID;
          $condidate = Interview::where(function($query) use($search, $uid) {
              $query->whereRaw('FIND_IN_SET('.$uid.',interviewerID)');
              if($search){ 
                  $query->Where('condidate_name', 'LIKE', "%$search%");
              }
          })->Paginate($this->record_per_page); 
                    
          if($condidate->count())
          {   
            $user_id = $value->userID;
            break;
          } 
        }
        $c_name = $corporate_profile->company_url;  
        if($condidate==[])
        {   $condidates = $condidate;
            
            return view('packages::corporateProfile.condidate', compact('c_name','condidates', 'page_title', 'page_action'));  
        }    

        $my_data = [];
        foreach ($condidate as $key => $condidate_record) {
            
            $interviewer_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID);
            
            $my_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            'interviewer' => [$interviewer_data]
                        ];

        }
        $temp_data = [];
        $condidate =''; 
        $data= [];

        foreach ($user_from_same_company as $key => $user_record) {
            $condidate =  Interview::whereRaw('FIND_IN_SET('.$user_record->userID.',interviewerID)')
                                    ->Where('condidate_name', 'LIKE', "%$search%")
                                    ->Paginate($this->record_per_page);
            if($condidate->count()==0)
            {   
              continue;
            } 
            $pagination =  $condidate;
            foreach ($condidate as $key => $condidate_record) {
            
            $interviewer_all_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID);

            
             $temp_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            'interviewer' => [$interviewer_all_data]
                        ]; 
            }
        }

        $all_data = array();
        foreach ($temp_data as $key => $value) {
                 $all_data[$value['condidateID']] = $value;

            }
        foreach ($all_data as $key => $value) {
               
               $data[] =   $value;   
        }        
        $condidates = $data ;
        
        return view('packages::corporateProfile.condidate', compact('c_name'  ,'pagination','condidates', 'page_title', 'page_action'));
    }
   /*
    * Method: recentInterview 
    */
    public function recentInterview(Request $request,$user_id)
    {
          
        $search =  $request->get('search'); 
        $page_action =   "Recent Interview";
        $page_title  =   "Interview"; 
        $month = $request->get('month');
        $interview = Interview::
                    with([ 'InterviewRating' => function($query) use ($user_id) {
                        $query->where('interviewerID', $user_id);
                      }])
                    ->where(function($query) use($user_id,$search,$month){
                            $query->whereRaw('FIND_IN_SET('.$user_id.',interviewerID)'); 
                            if($search){ 
                                  $query->Where('condidate_name', 'LIKE', "%$search%");
                              }
                             if($month){ 
                                  $query->whereMonth('created_at', '=', $month);
                              }  
                            }
                        )
                    ->get();
        $d = $this->getRecentRecord($request,$user_id);  
        $resetUrl = $request->url();  
        $report_url = $request->url().'?report=pdf';
        $report = $request->get('report');
        $userName = User::find($user_id);
        $userName = $userName->first_name.' '.$userName->last_name;
        if($report=='pdf')
        {
           
           $pdf = PDF::loadView('packages::corporateProfile.recent_interview_pdf', compact('resetUrl','interview', 'page_title', 'page_action','report_url','userName'));
           return ($pdf->download('recent-interview.pdf'));
        }
        $ratingStatus = $request->get('ratingStatus');
        
        return view('packages::corporateProfile.recent_interview', compact('ratingStatus','month','resetUrl','interview', 'page_title', 'page_action','report_url','userName'));

    }
    public function getRecentRecord($request,$userID)
    {
         
        $user_id =  $userID;
        $is_user_exist = Helper::isUserExist($user_id);
        $search = $request->get('search');
        if(!$is_user_exist){
            return "Record not found";
        }

        $corp_profile       = CorporateProfile::where('userID',$user_id)->get();
        $corp_profile_name  = $corp_profile->lists('company_url','userID');
        $user_from_same_company = CorporateProfile::where('company_url',$corp_profile_name[$user_id])->get();
        
        $get_interviewer_list = User::whereIn('userID', $user_from_same_company->lists('userID'))
                                     ->where('status',1)->get();
       // $condidate =  Interview::whereRaw('FIND_IN_SET('.$user_id.',interviewerID)')->get();
        $query =  Interview::query();
        $query->whereRaw('FIND_IN_SET('.$user_id.',interviewerID)');
        $condidate =  $query->get();
        
        if($condidate->count()==0)
        {
           return  "Directory data not found"; 
        } 
        $my_data = [];
        foreach ($condidate as $key => $condidate_record) {
             
            $interviewer_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID,$condidate_record->id);
            //dd($interviewer_data );
            $rating = Helper::getRatingByCondidateID($condidate_record->id);
            // Rating pending if not rated by all user
            $is_evaluate = InterviewRating::where('condidateID',$condidate_record->id)->count();   
            $interviewer_count =  count($interviewer_data);
            $condidate_count_evaluation = $is_evaluate;
           
            $my_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            'ratingStatus' => ($interviewer_count==$condidate_count_evaluation)?'Evaluated':"Pending",
                            'interviewerDetail' => $interviewer_data
                        ];

        }
        $temp_data = [];
        $condidate =''; 
        $data= [];
        foreach ($user_from_same_company as $key => $user_record) {
            //$condidate =  Interview::whereRaw('FIND_IN_SET('.$user_record->userID.',interviewerID)')->get();
            $query =  Interview::query();
            $query->whereRaw('FIND_IN_SET('.$user_record->userID.',interviewerID)');
            $condidate =  $query->get();

            foreach ($condidate as $key => $condidate_record) {
            
            $interviewer_all_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID,$condidate_record->id);
            $rating   = Helper::getRatingByCondidateID($condidate_record->id);
            // Rating pending if not rated by all user
            $is_evaluate = InterviewRating::where('condidateID',$condidate_record->id)->count();   
            $interviewer_count =  count($interviewer_all_data);
            $condidate_count_evaluation = $is_evaluate;
            
            $temp_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            //'ratingStatus' => ($rating>0)?'Evaluated':"Pending",
                            'ratingStatus' => ($interviewer_count==$condidate_count_evaluation)?'Evaluated':"Pending",
                            'interviewDetail' => $interviewer_all_data
                        ]; 

            }
        }

        $all_data = array();
        foreach ($temp_data as $key => $value) {
                 $all_data[$value['condidateID']] = $value;

            }
        foreach ($all_data as $key => $value) {
               
               $data[] =   $value;  

        }        
        $search = 'date'; 
 

        if($search)
        {
           $data = array_values($data); 
           $my_data = array_values($my_data);
        } 
        return   $data;

    }
    /*
    * Method Name : condidateDirectory
    * Request : condidate all directory
    */
    public function condidateDirectory(Request $request , Interview $interview){
        
        $page_title = "Candidate Directory";
        $page_action = "View Directory";
        $resetUrl = $request->url();
        
        $search = $request->get('search');
        $download_url =  $request->url().'?report=pdf&search='.$search;
        $condidates =   Interview::from( 't_interview as i' )
                            ->join( 't_user as u', DB::raw( 'u.userID' ), '=', DB::raw( 'i.interviewerID' ) )
                            ->join( 't_corporate_profile as cp', DB::raw( 'cp.userID' ), '=', DB::raw( 'u.userID' ) )
                            ->select( DB::raw( 'i.*,u.*,cp.company_url,cp.id as company_id' ) )
                            ->where(function($query) use($search){
                               if($search)
                               {
                                    $query->orWhere('company_url','LIKE',"%$search%");
                                    $query->orWhere('condidate_name','LIKE',"%$search%");
                                    $query->orWhere('short_description','LIKE',"%$search%");
                               }
                              
                        })->orderBy('id','DESC')->Paginate($this->record_per_page);

        $report = $request->get('report'); 

        $page = $request->get('page');
        $page = ($page==1)?0:($page-1); 
        $page_count = $this->record_per_page;

        if($report=='pdf')
        {
           $condidates =   Interview::from( 't_interview as i' )
                            ->join( 't_user as u', DB::raw( 'u.userID' ), '=', DB::raw( 'i.interviewerID' ) )
                            ->join( 't_corporate_profile as cp', DB::raw( 'cp.userID' ), '=', DB::raw( 'u.userID' ) )
                            ->select( DB::raw( 'i.*,u.*,cp.company_url,cp.id as company_id' ) )
                            ->where(function($query) use($search){
                               if($search)
                               {
                                    $query->orWhere('company_url','LIKE',"%$search%");
                                    $query->orWhere('condidate_name','LIKE',"%$search%");
                                    $query->orWhere('short_description','LIKE',"%$search%");
                               }
                              
                        })->orderBy('id','DESC')->get();
           $pdf = PDF::loadView('packages::interview.condidate_pdf', compact('page','page_count','download_url','condidates','page_title', 'page_action'));
           return ($pdf->download('condidate-directory.pdf'));
        }

        return view('packages::interview.condidate', compact('page','page_count','download_url','condidates','page_title', 'page_action'));

    }
    

}
