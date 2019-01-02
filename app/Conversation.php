<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function messages(){
    	return $this->hasMany('App\Message', 'conversation_id');
    }

    public function notifications(){
    	return $this->hasMany('App\MessageNotification', 'conversation_id');
    }

    public function from(){
    	return $this->belongsTo('App\User', 'from_id');
    }

    public function to(){
    	return $this->belongsTo('App\User', 'to_id');
    }


}
