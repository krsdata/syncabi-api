<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class CourseRequest extends Request {

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
                            'course_name'   => "required" ,  
                            'session_id' => 'required',
                            'grade_weight' => 'required' 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $course = $this->course ) {

                        return [
                            'course_name'   => "required" ,  
                            'session_id' => 'required',
                            'grade_weight' => 'required' 
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
