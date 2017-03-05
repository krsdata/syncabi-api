<?php

namespace  App; 

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\User','intervewerID','userID');
    }

    public function CondidateInterview()
    {
        return $this->belongsTo('App\Interview','condidateID','id');
    }
}
