<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interviews';
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
