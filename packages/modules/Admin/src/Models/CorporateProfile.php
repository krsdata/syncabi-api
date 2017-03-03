<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;

class CorporateProfile extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'corporate_profiles';
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
        return $this->belongsTo('Modules\Admin\Models\User','userID','userID');
    }
}
