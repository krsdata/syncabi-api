<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\AssignmentRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Assignment;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Hash;
use View;
use URL;
use Lang;
use Session;
use DB;
use Route;
use Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use App\Helpers\Helper; 
use App\ProfessorProfile;
use App\StudentProfile;
use Modules\Admin\Models\Course;
 

/**
 * Class AdminController
 */
class AssignmentController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        
    }
  

    /*
     * Dashboard
     * */

    public function index(Assignment $assignment, Request $request) 
    { 
        $page_title = 'Assignment';
        $page_action = 'View Assignment'; 
        if ($request->ajax()) {
            $id = $request->get('id');
            $status = $request->get('status');
            $user = User::find($id);
            $s = ($status == 1) ? $status = 0 : $status = 1;
            $user->status = $s;
            $user->save();
            echo $s;
            exit();
        }
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search)) OR  (isset($status) && !empty($status)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $assignment = Assignment::with('user')->with('course')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%")
                                    ->OrWhere('email', 'LIKE', "%$search%");
                        } 
                    })->Paginate($this->record_per_page);
        } else {
            $assignment = Assignment::with('user')->with('course')->orderBy('id','desc')->Paginate($this->record_per_page);
            
        }
         

        return view('packages::assignment.index', compact('assignment','status','users', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Assignment $assignment) 
    {
        $page_title     =   'Assignment';
        $page_action    =   'Create Assignment';
        $users          =   User::where('role_type',1)->get();
        $course         =   Course::all();
        return view('packages::assignment.create', compact('assignment','users','course', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(AssignmentRequest $request, Assignment $assignment) {
        $cid = Course::find($request->get('course_id')); 


        $assignment->fill(Input::all()); 
        $assignment->professor_id = $cid->professor_id; 
       // $assignment->save(); 
       
        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Assignment $assignment) {

        $page_title = 'Assignment';
        $page_action = 'Show Assignment';
        $users          =   User::where('role_type',1)->get();
        $course         =   Course::all();
        return view('packages::assignment.edit', compact('assignment','users','course', 'page_title', 'page_action'));
   
    }

    public function update(Request $request, Assignment $assignment) {
        
        $assignment->fill(Input::all());
        $assignment->save();
        return Redirect::to(route('assignment'))
                        ->with('flash_alert_notice', 'Assignment was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Assignment $assignment) {
        Assignment::where('id',$assignment->id)->delete();
        return Redirect::to(route('assignment'))
                        ->with('flash_alert_notice', 'Assignment was successfully deleted!');
    }

    public function show(Assignment $assignment) {
        
    }

}
