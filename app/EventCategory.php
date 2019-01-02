<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function events(){
    	return $this->hasMany('App\Event', 'category_id');
    }
}
