<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Http\Requests\PositionRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\Position;
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
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class AdminController
 */
class PositionController extends Controller {
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
        View::share('viewPage', 'Position');
        $this->record_per_page = Config::get('app.record_per_page');
    }
    protected $softDelete = true; 

    /*
     * Dashboard
     * */

    public function index(Position $position, Request $request) 
    {   
        $page_title = 'Position';
        $page_action = 'View Position'; 
        $search = Input::get('search');
        if (isset($search) && !empty($search)) {

            $search = isset($search) ? Input::get('search') : ''; 
            $position = Position::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('position_name', 'LIKE', "%$search%"); 
                        }
 
                    })->Paginate($this->record_per_page);
        } else { 
            $position = Position::Paginate($this->record_per_page);
        } 
        return view('packages::position.index', compact('position', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Position $position) 
    {
        $page_title = 'Position';
        $page_action = 'Create Position';
        return view('packages::position.create', compact('position', 'page_title', 'page_action', 'groups'));
    }

    /*
     * Save Group method
     * */

    public function store(PositionRequest $request, Position $position) 
    {
        $user =  User::find(Auth::user()->userID);
        /*$helper = new Helper;
        $c_name = $helper->getCorporateGroupName($user->email);
        $c_url = $helper->getCompanyUrl($user->email);
        */
        $position->position_name = $request->get('position_name'); 
        $position->email = $user->email;
        $position->save();
        /*$position->corporate_group_name = $c_name;
        $position->company_url = $c_url;*/

        return Redirect::to(route('position'))
                        ->with('flash_alert_notice', 'New position was successfully created.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Position $position) {
        $page_title = 'Position';
        $page_action = 'Show Position';
        return view('packages::position.edit', compact('position', 'page_title', 'page_action'));
    }

    public function update(PositionRequest $request, Position $position) {
        
        $position->position_name = $request->get('position_name'); 
        $position->save();
        return Redirect::to(route('position'))
                        ->with('flash_alert_notice', 'Position was  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Position $position) {
        Position::destroy($position->id); 
        //Position::withTrashed()->restore();
        return Redirect::to(route('position'))
                        ->with('flash_alert_notice', 'Position was successfully deleted!');
    }

    public function show(Position $position) {
        
    }

}
