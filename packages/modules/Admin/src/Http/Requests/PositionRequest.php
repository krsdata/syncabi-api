<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class PositionRequest extends Request {

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
                            'position_name'   => "required|unique:t_position",  
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $position = $this->position ) {

                        return [
                           'position_name'   => "required", 
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
