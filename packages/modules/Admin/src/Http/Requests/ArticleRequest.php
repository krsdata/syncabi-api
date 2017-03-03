<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ArticleRequest  extends Request {

    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules() { 
            switch ( $this->method() ) {
                case 'GET':
                case 'DELETE': {
                        return [ ];
                    }
                case 'POST': {
                        return [
                            'article_title'   => "required|unique:articles,article_title" ,  
                            'article_category' => 'required', 
                            'description' => 'required'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $article = $this->article ) {

                        return [
                            'article_title'   => "required" ,  
                            'article_category' => 'required',
                            'description' => 'required'
                        ];
                    }
                }
                default:break;
            }
        //}
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
