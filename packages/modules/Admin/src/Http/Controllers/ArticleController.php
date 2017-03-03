<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ArticleRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\Article;
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
class ArticleController extends Controller {
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
        View::share('viewPage', 'article');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Article $category, Request $request) 
    { 
        $page_title = 'Article';
        $page_action = 'View Article'; 
        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Article::find($id); 
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
               
            $articles = Article::with('category')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('article_title', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $articles = Article::with('category')->orderBy('id','desc')->Paginate($this->record_per_page);
        }
        

        $a = Article::with('category')->orderBy('id','desc')->Paginate($this->record_per_page);
        
        
        return view('packages::article.index', compact('articles', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Article $article) 
    {
         
        $page_title = 'Article';
        $page_action = 'Create Article';
        $sub_category_name  = Article::all();
        $category   = Category::all();
        $cat = [];
        foreach ($category as $key => $value) {
             $cat[$value->category_name][$value->id] =  $value->sub_category_name;
        }
        


        return view('packages::article.create', compact( 'cat','category','article','sub_category_name', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(ArticleRequest $request, Article $article) {
        
      /*  return Redirect::to(route('article'))
                            ->with('flash_alert_notice', 'New Article was successfully created !');
       */ 

        $article->fill(Input::all());   
        $article->save(); 
       
        return Redirect::to(route('article'))
                            ->with('flash_alert_notice', 'New Article was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Article $article) {

        $page_title = 'Article';
        $page_action = 'Show Article'; 
        $category   = Category::all();  
        $cat = [];
        foreach ($category as $key => $value) {
             $cat[$value->category_name][$value->id] =  $value->sub_category_name;
        } 
        
        return view('packages::article.edit', compact( 'cat','article', 'page_title', 'page_action'));
    }

    public function update(ArticleRequest $request, Article $article) {
           
        $article->fill(Input::all()); 
        $article->save();
        return Redirect::to(route('article'))
                        ->with('flash_alert_notice', 'Article was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Article $article) {
        
        Article::where('id',$article->id)->delete();

        return Redirect::to(route('article'))
                        ->with('flash_alert_notice', 'Article was successfully deleted!');
    }

    public function show(Article $article) {
        
    }

}
