<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function event(){
    	return $this->belongsTo('App\Event', 'event_id');
    }
}
