<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class RatingFeedbackRequest extends Request {

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
                            'feedback'   => "required",
                            'rating_value' =>   "required|max:5"
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $ratingFeedback = $this->ratingFeedback ) {

                        return [
                            'feedback'   => "required",
                            'rating_value' =>   "required|max:5"
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
