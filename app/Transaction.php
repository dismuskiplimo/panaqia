<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'completed_at'];

    public function event(){
    	return $this->belongsTo('App\Event', 'event_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
