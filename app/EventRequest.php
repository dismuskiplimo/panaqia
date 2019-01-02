<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'approved_at', 'paid_at'];

    public function user(){
    	return $this->belongsTo('App\User','from_id');
    }


    public function event(){
    	return $this->belongsTo('App\Event','event_id');
    }
}
