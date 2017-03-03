<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class DefaultCriteriaRequest extends Request {

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
                            'criteria_name'   => "required|unique:default_criteria,criteria_name",
                            'criteria_rating_value_1' =>   "required",
                            'criteria_rating_value_2' =>   "required",
                            'criteria_rating_value_3' =>   "required",
                            'criteria_rating_value_4' =>   "required",
                            'criteria_rating_value_5' =>   "required"
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $defaultCriteria = $this->defaultCriteria) {

                        return [
                            'criteria_name'   => "required",
                            'criteria_rating_value_1' =>   "required",
                            'criteria_rating_value_2' =>   "required",
                            'criteria_rating_value_3' =>   "required",
                            'criteria_rating_value_4' =>   "required",
                            'criteria_rating_value_5' =>   "required"
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
