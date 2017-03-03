<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interview_criterias';
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
