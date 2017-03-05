<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\Position;
use Auth;

class User extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 't_user';
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
    protected $primaryKey = 'userID';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name','last_name','phone','mobile','email','positionID', 
                            'deviceID','device_token','remember_token'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function position()
    {
        return $this->belongsTo('Modules\Admin\Models\Position','positionID','id');
    }
    public function corporateProfile()
    {
        return $this->hasOne('Modules\Admin\Models\CorporateProfile','userID','userID');
    }

    public function evaluatedCondidate()
    {
        return $this->hasMany('Modules\Admin\Models\InterviewRating','interviewerID','userID');
    }
}
