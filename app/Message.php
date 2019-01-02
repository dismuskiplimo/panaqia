<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'read_at'];


    public function sender(){
    	return $this->belongsTo('App\User', 'from_id');
    }


    public function receiver(){
    	return $this->belongsTo('App\User', 'to_id');
    }
}
