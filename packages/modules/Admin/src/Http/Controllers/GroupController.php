<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\GroupRequest;
use Modules\Admin\Models\Group;
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

/**
 * Class AdminController
 */
class GroupController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        $this->middleware('AdminAuth');
        View::share('viewPage', 'group');
    }

    /*
     * Dashboard
     * */

    public function index(Group $group, Request $request) {

        $groups = Group::all();
        $page_title = 'Group';
        $page_action = 'View Group';
        return view('packages::users.group.index', compact('groups', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Group $group) {

        $page_title = 'Group';
        $page_action = 'Create Group';
        return view('packages::users.group.create', compact('group', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(GroupRequest $request, Group $group) {
        $group->fill(Input::all());
        $group->save();
        return Redirect::to(route('group.create'))
                        ->with('flash_alert_notice', 'New group was successfully created !')->with('alert_class', 'alert-success alert-dismissable');
    }

    /*
     * Edit Group method
     * */

    public function edit(Group $group) {
        
        $page_title = 'Group';
        $page_action = 'Edit Group';
        return view('packages::users.group.edit', compact('group', 'page_title', 'page_action'));
    }

    public function update(GroupRequest $request, Group $group) {
        $group->fill(Input::all());
        $group->save();
        return Redirect::to(route('group'))
                        ->with('flash_alert_notice', 'Group was successfully updated !');
    }

    public function destroy(Coupon $coupon) {
        
    }

    public function show(Group $group) {
        
    }

}
