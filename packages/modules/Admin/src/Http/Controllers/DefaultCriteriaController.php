<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request; 
use Modules\Admin\Http\Requests\DefaultCriteriaRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\DefaultCriteria;
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
class DefaultCriteriaController extends Controller {
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
        View::share('viewPage', 'Default Criteria');
        $helper = new Helper; 
        View::share('helper',$helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }
    protected $criteria;
    /*
     * Default Criteria
     * */
    public function index(DefaultCriteria $defaultCriteria, Request $request) {

        $page_title = 'Default Criteria';
        $page_action = 'View Default Criteria'; 
        $search = Input::get('search');
        if (isset($search) && !empty($search)) {

            $search = isset($search) ? Input::get('search') : ''; 
            $defaultCriteria = DefaultCriteria::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('criteria_name', 'LIKE', "%$search%"); 
                        }
 
                    })->Paginate($this->record_per_page);
        } else { 
            $defaultCriteria = DefaultCriteria::Paginate($this->record_per_page);
        }  
         
        return view('packages::defaultCriteria.index', compact('defaultCriteria', 'page_title', 'page_action'));
    }

    /*
     * create  method
     * */

    public function create(DefaultCriteria $defaultCriteria) 
    {
        $page_title = 'Default Criteria';
        $page_action = 'Create Default Criteria';  
        return view('packages::defaultCriteria.create', compact('defaultCriteria', 'page_title', 'page_action', 'groups'));
    }

    /*
     * Save  method
     * */

    public function store(DefaultCriteriaRequest $request, DefaultCriteria $defaultCriteria) 
    {
       
        $defaultCriteria->criteria_name = $request->get('criteria_name'); 
        $defaultCriteria->criteria_rating_value_1 = $request->get('criteria_rating_value_1');
        $defaultCriteria->criteria_rating_value_2 = $request->get('criteria_rating_value_2'); 
        $defaultCriteria->criteria_rating_value_3 = $request->get('criteria_rating_value_3'); 
        $defaultCriteria->criteria_rating_value_4 = $request->get('criteria_rating_value_4'); 
        $defaultCriteria->criteria_rating_value_5 = $request->get('criteria_rating_value_5');  
        $defaultCriteria->save();
        return Redirect::to(route('defaultCriteria'))
                        ->with('flash_alert_notice', 'Default Rating Criteria was successfully created.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(DefaultCriteria $defaultCriteria) {
        $page_title = 'Default Rating';
        $page_action = 'Edit'; 
        $ratingdetails = DefaultCriteria::all();
        return view('packages::defaultCriteria.edit', compact('ratingdetails','defaultCriteria', 'page_title', 'page_action'));
    }

    public function update(DefaultCriteriaRequest $request, DefaultCriteria $defaultCriteria) {
       
        $defaultCriteria->criteria_name = $request->get('criteria_name'); 
        $defaultCriteria->criteria_rating_value_1 = $request->get('criteria_rating_value_1');
        $defaultCriteria->criteria_rating_value_2 = $request->get('criteria_rating_value_2'); 
        $defaultCriteria->criteria_rating_value_3 = $request->get('criteria_rating_value_3'); 
        $defaultCriteria->criteria_rating_value_4 = $request->get('criteria_rating_value_4'); 
        $defaultCriteria->criteria_rating_value_5 = $request->get('criteria_rating_value_5');  
        $defaultCriteria->save();

        return Redirect::to(route('defaultCriteria'))
                        ->with('flash_alert_notice', 'Rating Feedback was  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(DefaultCriteria $defaultCriteria) {
 
        $defaultCriteria =    DefaultCriteria::where('id',$defaultCriteria->id)->delete();
        DefaultCriteria::withTrashed()->restore();
        if($defaultCriteria){
            return Redirect::to(route('defaultCriteria'))
                        ->with('flash_alert_notice', 'Default Criteria was successfully deleted.');
        }else{
            return Redirect::to(route('defaultCriteria'))
                        ->with('flash_alert_notice', 'Something went wrong!');
        } 
        
    }

    public function show(RatingFeedback $ratingFeedback) {
      
    }

}
