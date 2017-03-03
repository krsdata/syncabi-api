<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CategoryRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Category;
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

/**
 * Class AdminController
 */
class SubCategoryController extends Controller {
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
        View::share('viewPage', 'Sub-category');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request) 
    { 
        $page_title = 'Sub category';
        $page_action = 'View Sub Category'; 
        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Category::find($id); 
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        }
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
               
            $categories = Category::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('category_name', 'LIKE', "%$search%")
                                    ->OrWhere('sub_category_name', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $categories = Category::orderBy('id','desc')->Paginate($this->record_per_page);
        }
        
        
        return view('packages::category.index', compact('categories', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Category $category) 
    {
        $page_title     = 'Category';
        $page_action    = 'Create Sub-category';
        $sub_category_name  = Category::groupBy('category_name')->lists('category_name','category_name');

        $category_list = $sub_category_name->toArray(); 

        if($sub_category_name->count()==0){  
           return Redirect::to(route('category.create'));
        }

        return view('packages::sub_category.create', compact( 'category_list','category','sub_category_name', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(CategoryRequest $request, Category $category) {
        
        $category->fill(Input::all());   
        $category->save(); 
       
        return Redirect::to(route('category'))
                            ->with('flash_alert_notice', 'New category was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Category $category) {

        $page_title = 'Category';
        $page_action = 'Edit Sub-category';  
        $sub_category_name  = Category::groupBy('category_name')->lists('category_name','category_name');

        $category_list = $sub_category_name->toArray();

        return view('packages::sub_category.edit', compact('category_list', 'sub_category_name','category', 'page_title', 'page_action'));
    }

    public function update(Request $request, Category $category) {
        
        $category->fill(Input::all()); 
        $category->save();
        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Category was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Category $category) {
        
        Category::where('id',$category->id)->delete();

        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Category was successfully deleted!');
    }

    public function show(Category $category) {
        
    }

}
