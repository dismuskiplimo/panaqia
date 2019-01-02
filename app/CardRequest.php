<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function sender(){
    	return $this->belongsTo('App\User', 'from_id');
    }


    public function card(){
    	return $this->belongsTo('App\Card', 'card_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'to_id');
    }
}
