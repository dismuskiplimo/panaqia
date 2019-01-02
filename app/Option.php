<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function money(){
    	return $this->belongsTo('App\Currency', 'currency', 'code');
    }
}
