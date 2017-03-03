<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteUser extends Model
{
    
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invite_users';
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

    protected $fillable = ['email','userID','deviceToken'];  // All field of user table here    

}
