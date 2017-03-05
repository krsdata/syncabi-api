<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RatingFeedback extends BaseModel {

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rating_feedback';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     /**
     * The primary key used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}

