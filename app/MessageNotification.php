<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageNotification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'read_at'];


    public function mine(){
    	return $this->belongsTo('App\User', 'to_id');
    }
}
