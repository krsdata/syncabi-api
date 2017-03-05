<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Review extends BaseModel {

    /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 't_review';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['UserID','Date','Rate','Text','saving','Approved'];
}


