<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Group extends BaseModel {

    /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $guarded = ['created_at' , 'updated_at'  ];
    protected $fillable = ['Title','Repository','DefaultPage'];
    
    
    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User','id','GroupID');
    }

}


