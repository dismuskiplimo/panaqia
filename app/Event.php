<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at', 'start_date', 'end_date', 'cancelled_at', 'withdrawn_at', 'closed_at', 'featured_from', 'featured_until'];

    public function requests(){
    	return $this->hasMany('App\EventRequest', 'event_id');
    }

    public function likes(){
        return $this->hasMany('App\EventLike', 'event_id');
    }

    public function social_links(){
        return $this->hasMany('App\EventSocial', 'event_id');
    }

    public function sponsors(){
        return $this->hasMany('App\Sponsor', 'event_id');
    }


    public function discussions(){
        return $this->hasMany('App\Discussion', 'event_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function timezone(){
        return $this->belongsTo('App\Timezone', 'timezone_id');
    }

    public function withdrawer(){
        return $this->belongsTo('App\User','withdrawn_by');
    }

    public function category(){
    	return $this->belongsTo('App\EventCategory', 'category_id');
    }


    public function tags(){
        return $this->hasMany('App\EventTag', 'event_id');
    }
}
