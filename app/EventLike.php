<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLike extends Model
{
    public function event(){
    	return $this->belongsTo('App\Event', 'event_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'event_id');
    }
}
