<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_interview';
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
    
    public function interviewRating()
    {
        return $this->hasMany('Modules\Admin\Models\InterviewRating','condidateID');
    }
}
