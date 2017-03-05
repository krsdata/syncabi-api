<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewRating extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_interview_rating';
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

    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User','intervewerID','userID');
    }

    public function CondidateInterview()
    {
        return $this->belongsTo('Modules\Admin\Models\Interview','condidateID','id');
    }
}
