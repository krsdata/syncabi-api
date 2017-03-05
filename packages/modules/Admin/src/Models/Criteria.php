<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
     use SoftDeletes;
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_interview_criteria';
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
    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User','created_by','userID');
    }
}
