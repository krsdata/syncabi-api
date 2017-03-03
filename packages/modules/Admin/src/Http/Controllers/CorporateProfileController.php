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
/**
 * Class AdminController
 */
class CorporateProfileController extends Controller {
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
        $helper = new Helper;
        View::share('helper',$helper);
    }
    protected $criteria;
    /*
     * Dashboard
     * */
    public function index(CorporateProfile $corporateProfile, Request $request) 
    { 
        $page_title = 'Corporate Profile';
        $page_action = 'View Corporate Profile'; 
        $search = Input::get('search');
        if (isset($search) && !empty($search)) { 
            $search = isset($search) ? Input::get('search') : ''; 
            $corporateProfile = CorporateProfile::with('user')
                        ->selectRaw('count(*) as count,company_name,id,company_url,created_at,userID')
                        ->orderBy('id','desc')->groupBy('company_url')
                        ->where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('company_name', 'LIKE', "%$search%");
                            $query->orWhere('company_url', 'LIKE', "%$search%");  
                        }
 
                    })->Paginate($this->record_per_page);
        } else {

            $corporateProfile = CorporateProfile::with('user')->selectRaw('count(*) as count,company_name,id,company_url,created_at,userID')->orderBy('id','desc')->groupBy('company_url')->Paginate($this->record_per_page);

        }  
         
        $report = $request->get('report');
        if($report=='pdf')
        {
           $pdf = PDF::loadView('packages::corporateProfile.pdf', compact('corporateProfile', 'page_title', 'page_action'));
           return ($pdf->download('corporate-profile.pdf'));
        }
        
        return view('packages::corporateProfile.index', compact('corporateProfile', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(CorporateProfile $criteria) 
    {
      
    }

    /*
     * Save Group method
     * */

    public function store(CorporateProfileRequest $request, CorporateProfile $corporateProfile) 
    {
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
        $report = $request->get('report');
        $download_url =  $request->url().'?report=pdf';

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
          $month  =  $request->get('month');
          $uid = $value->userID;
          $condidate = Interview::where(function($query) use($search, $uid,$month) {
              $query->whereRaw('FIND_IN_SET('.$uid.',interviewerID)');
              if($search){ 
                  $query->Where('condidate_name', 'LIKE', "%$search%");
              }
              if($month){ 
                  $query->whereMonth('created_at', '=', $month);
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
            
            return view('packages::corporateProfile.condidate', compact('download_url','c_name','condidates', 'page_title', 'page_action'));  
        }    

        $my_data = [];
        foreach ($condidate as $key => $condidate_record) {
            
            $interviewer_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID);
            
             $is_evaluate = InterviewRating::where('condidateID',$condidate_record->id)->count();   
              $interviewer_count =  count($interviewer_data);
              $condidate_count_evaluation = $is_evaluate;

              $is_future     = \Carbon\Carbon::parse($condidate_record->interview_date)->isFuture();
              $is_past       = \Carbon\Carbon::parse($condidate_record->interview_date)->isPast();
              


              if($is_future===true){
                  $rs = "Upcoming";
              }elseif ($is_past===true) {
                   $rs = "pending";
              }else{
                  $rs = "pending"; 
              }

            $my_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'created_date' => $condidate_record->created_at,
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            'ratingStatus' => ($interviewer_count==$condidate_count_evaluation)?'Evaluated':$rs,
                            'interviewer' => [$interviewer_data]
                        ];

        }
        $temp_data = [];
        $condidate =''; 
        $data= [];

        foreach ($user_from_same_company as $key => $user_record) {
            $condidate =  Interview::whereRaw('FIND_IN_SET('.$user_record->userID.',interviewerID)')
                                    ->Where('condidate_name', 'LIKE', "%$search%") 
                                    ->where(function($query)use($month){
                                      if($month){ 
                                            $query->whereMonth('created_at', '=', $month);
                                        }
                                      })
                                    ->Paginate($this->record_per_page);
            if($condidate->count()==0)
            {   
              continue;
            } 
            $pagination =  $condidate;
            foreach ($condidate as $key => $condidate_record) {
            
            $interviewer_all_data = Helper::getInterviewerFromInterview($condidate_record->interviewerID);

             $is_evaluate = InterviewRating::where('condidateID',$condidate_record->id)->count();   
             $interviewer_count =  count($interviewer_all_data);
             $condidate_count_evaluation = $is_evaluate;
             $is_future       = \Carbon\Carbon::parse($condidate_record->interview_date)->isFuture();
             $is_past       = \Carbon\Carbon::parse($condidate_record->interview_date)->isPast();

              

              if($is_future===true){
                  $rs = "Upcoming";
              }elseif ($is_past===true) {
                   $rs = "pending";
              }else{
                  $rs = "pending"; 
              }      
            
             $temp_data[] =   [
                            'condidateName' =>  $condidate_record->condidate_name,
                            'condidateID' =>  $condidate_record->id,
                            'shortDescription' => $condidate_record->short_description,
                            'comment'   =>    $condidate_record->comment,
                            'created_date' => $condidate_record->created_at, 
                            'rating'    => Helper::getRatingByCondidateID($condidate_record->id),
                            'ratingStatus' => ($interviewer_count==$condidate_count_evaluation)?'Evaluated':$rs,
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

        if($report=='pdf')
        {
           $pdf = PDF::loadView('packages::corporateProfile.condidate_pdf',compact('download_url','c_name'  ,'pagination','condidates', 'page_title', 'page_action'));
           return ($pdf->download('corporate-profile.pdf'));
        }
        //dd($condidates);
        return view('packages::corporateProfile.condidate', compact('month','download_url','c_name'  ,'pagination','condidates', 'page_title', 'page_action'));
    }
    public function corporateUser($name,Request $request)
    { 
        $page_title ="Corporate Profile";
        $page_action = $name;
        $cp =  CorporateProfile::with('user')->where('company_url',$name)->get();
        $month = $request->get('month');
     
        $user_result = Interview::whereMonth('created_at', '=', $month)->lists('interviewerID')->toArray();
        $array_merge = [];
        foreach (array_merge(array_unique($user_result)) as $key => $value) {
           $arr = str_getcsv($value);
           $array_merge = array_unique(array_merge($array_merge,$arr));
        }
        $evaluation_by_month =  (count($array_merge)>0)?$array_merge:'';

        $user_ids = [];
        foreach ($cp as $key => $cp_user) {
          $user_ids[] = $cp_user->userID;
         } 
        $search =  $request->get('search');
        
        $users = User::with('position','corporateProfile')->whereIn('userID',$user_ids );

        $status = $request->get('status');
        if($status=='active')
        {
          $users = $users->where('status',1)->paginate($this->record_per_page);
        }else
        {
         $users =  $users->paginate($this->record_per_page); 
        }
        
        $search = Input::get('search');
        if (isset($search) && !empty($search)) {

            $search = isset($search) ? Input::get('search') : '';
               
            $users = User::with('position','corporateProfile')->where(function($query) use($search,$user_ids) {
                            if (!empty($search)) {
                            $query->Where('first_name', 'LIKE', "%$search%")
                                    ->OrWhere('last_name', 'LIKE', "%$search%")
                                    ->OrWhere('email', 'LIKE', "%$search%");
                                     
                            }
                    })->whereIn('userID',$user_ids );

            if($status=='active')
            {
              $users = $users->where('status',1)->paginate($this->record_per_page);
            }else
            {
              $users = $users->paginate($this->record_per_page);
            } 
        } 
        
        $download_url =  $request->url().'?report=pdf'; 
        $report = $request->get('report');
        if($report=='pdf')
        {
           $pdf = PDF::loadView('packages::corporateProfile.corporate_user_pdf',compact('request','users', 'page_title', 'page_action'));
           return ($pdf->download('corporate_user.pdf'));
        }

        return view('packages::corporateProfile.corporate_user', compact('evaluation_by_month','month','download_url','request','users', 'page_title', 'page_action'));
    
    }
    

}
