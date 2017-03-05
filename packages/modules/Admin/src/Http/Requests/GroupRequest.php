<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class GroupRequest extends Request {

    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules() {
        //if ( $metrics = $this->metrics ) {
            switch ( $this->method() ) {
                case 'GET':
                case 'DELETE': {
                        return [ ];
                    }
                case 'POST': {
                        return [
                            'Title'   => "required|max:250|unique:t_group,Title" ,
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $group = $this->group ) {

                        return [
                          'Title'   => "required" ,
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
