<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request; 
use Modules\Admin\Http\Requests\RatingFeedbackRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\RatingFeedback;
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
class RatingFeedbackController extends Controller {
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
    public function index(RatingFeedback $ratingFeedback, Request $request) {

        $page_title = 'Rating Feedback';
        $page_action = 'Rating'; 
        $search = Input::get('search');
        if (isset($search) && !empty($search)) {

            $search = isset($search) ? Input::get('search') : ''; 
            $ratingFeedback = RatingFeedback::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('feedback', 'LIKE', "%$search%"); 
                        }
 
                    })->Paginate($this->record_per_page);
        } else { 
            $ratingFeedback = RatingFeedback::Paginate($this->record_per_page);
        } 
        //dd(User::all());
        return view('packages::ratingFeedback.index', compact('ratingFeedback', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(RatingFeedback $ratingFeedback) 
    {
        $page_title = 'Rating Feedback';
        $page_action = 'Create'; 
        $ratingdetails = RatingFeedback::all();
        return view('packages::ratingFeedback.create', compact('ratingdetails','ratingFeedback', 'page_title', 'page_action', 'groups'));
    }

    /*
     * Save Group method
     * */

    public function store(RatingFeedbackRequest $request, RatingFeedback $ratingFeedback) 
    {
       
        $ratingFeedback->rating_value = $request->get('rating_value'); 
        $ratingFeedback->feeback = $request->get('feeback'); 
       // $ratingFeedback->save(); 

        return Redirect::to(route('ratingFeedback'))
                        ->with('flash_alert_notice', 'New rating feedback was successfully created.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(RatingFeedback $ratingFeedback) {
        $page_title = 'Rating Feedback';
        $page_action = 'Edit'; 
        $ratingdetails = RatingFeedback::all();
        return view('packages::ratingFeedback.edit', compact('ratingdetails','ratingFeedback', 'page_title', 'page_action'));
    }

    public function update(RatingFeedbackRequest $request, RatingFeedback $ratingFeedback) {
       
        $ratingFeedback->rating_value = $request->get('rating_value'); 
        $ratingFeedback->feedback = $request->get('feedback'); 
        $ratingFeedback->save();

        return Redirect::to(route('ratingFeedback'))
                        ->with('flash_alert_notice', 'Rating Feedback was  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(RatingFeedback $ratingFeedback) {
 
        $criteria =    Criteria::where('id',$criteria->id)->delete();
        Criteria::withTrashed()->restore();
        if($criteria){
            return Redirect::to(route('ratingFeedback'))
                        ->with('flash_alert_notice', 'Criteria was successfully deleted.');
        }else{
            return Redirect::to(route('ratingFeedback'))
                        ->with('flash_alert_notice', 'Something went wrong!');
        } 
        
    }

    public function show(RatingFeedback $ratingFeedback) {
      
    }

}
