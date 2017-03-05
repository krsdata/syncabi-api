<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class CriteriaRequest extends Request {

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
                            'interview_criteria'   => "required|unique:t_interview_criteria",  
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $criteria = $this->criteria ) {

                        return [
                           'interview_criteria'   => "required", 
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
