<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function event(){
    	return $this->belongsTo('App\Event', 'event_id');
    }
}
