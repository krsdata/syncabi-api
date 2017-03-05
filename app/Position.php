<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_position';
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
