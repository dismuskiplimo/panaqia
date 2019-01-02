<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function contacts(){
    	return $this->hasMany('App\Contact', 'card_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
