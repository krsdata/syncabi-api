<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Http\Requests\CriteriaRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Group;
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
/**
 * Class AdminController
 */
class CriteriaController extends Controller {
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
        View::share('viewPage', 'Criteria');
        $helper = new Helper; 
        View::share('helper',$helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }
    protected $criteria;
    /*
     * Dashboard
     * */
    public function index(Criteria $criteria, Request $request) {

        $page_title = 'Criteria';
        $page_action = 'View Criteria'; 
        $search = Input::get('search');
        if (isset($search) && !empty($search)) {

            $search = isset($search) ? Input::get('search') : ''; 
            $criteria = Criteria::with('user')->where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('interview_criteria', 'LIKE', "%$search%"); 
                        }
 
                    })->Paginate($this->record_per_page);
        } else { 
            $criteria = Criteria::with('user')->Paginate($this->record_per_page);
        } 
        //dd(User::all());
        return view('packages::criteria.index', compact('criteria', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Criteria $criteria) 
    {
        $page_title = 'Criteria';
        $page_action = 'Create Criteria';
        return view('packages::criteria.create', compact('criteria', 'page_title', 'page_action', 'groups'));
    }

    /*
     * Save Group method
     * */

    public function store(CriteriaRequest $request, Criteria $criteria) 
    {
        $user =  User::find(Auth::user()->userID);
        /*$helper = new Helper;
        $c_name = $helper->getCorporateGroupName($user->email);
        $c_url = $helper->getCompanyUrl($user->email);
        */
        $criteria->interview_criteria = $request->get('interview_criteria'); 
        $criteria->save();
        /*$position->corporate_group_name = $c_name;
        $position->company_url = $c_url;*/

        return Redirect::to(route('criteria'))
                        ->with('flash_alert_notice', 'New criteria was successfully created.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Criteria $criteria) {
        $page_title = 'Criteria';
        $page_action = 'Show Criteria';
        return view('packages::criteria.edit', compact('criteria', 'page_title', 'page_action'));
    }

    public function update(CriteriaRequest $request, Criteria $criteria) {
       
        $criteria->interview_criteria = $request->get('interview_criteria'); 
        $criteria->save();
        return Redirect::to(route('criteria'))
                        ->with('flash_alert_notice', 'Criteria was  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Criteria $criteria) {
 
        $criteria =    Criteria::where('id',$criteria->id)->delete();
        Criteria::withTrashed()->restore();
        if($criteria){
            return Redirect::to(route('criteria'))
                        ->with('flash_alert_notice', 'Criteria was successfully deleted.');
        }else{
            return Redirect::to(route('criteria'))
                        ->with('flash_alert_notice', 'Something went wrong!');
        } 
        
    }

    public function show(Criteria $criteria) {
      
    }

}
