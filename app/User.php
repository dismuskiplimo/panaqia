<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at', 'last_seen'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'last_seen', 'usertype', 'country_code', 'suspended_at', 'suspended_until', 'activated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function card_requests(){
        return $this->hasMany('App\CardRequest', 'to_id');
    }

    public function sent_requests(){
        return $this->hasMany('App\CardRequest', 'from_id');
    }

    public function contacts(){
        return $this->hasMany('App\Contact', 'user_id');
    }

    public function memberships(){
        return $this->hasMany('App\Membership', 'user_id');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction', 'user_id');
    }

    public function notifications(){
        return $this->hasMany('App\AppNotification', 'to_id');
    }

    public function message_count(){
        return $this->hasMany('App\Message', 'to_id');
    }

    public function message_notifications(){
        return $this->hasMany('App\MessageNotification', 'to_id');
    }

    public function awards(){
        return $this->hasMany('App\Award', 'user_id');
    }

    public function hobbies(){
        return $this->hasMany('App\Hobby', 'user_id');
    }

    public function career_interests(){
        return $this->hasMany('App\CareerInterest', 'user_id');
    }

    public function skills(){
        return $this->hasMany('App\Skill', 'user_id');
    }

    public function work_experiences(){
        return $this->hasMany('App\WorkExperience', 'user_id');
    }

    public function references(){
        return $this->hasMany('App\Reference', 'user_id');
    }

    public function events(){
        return $this->hasMany('App\Event', 'user_id');
    }


    public function sent_event_requests(){
        return $this->hasMany('App\EventRequest', 'from_id');
    }

    public function event_requests(){
        return $this->hasMany('App\EventRequest', 'to_id');
    }


    public function card(){
        return $this->hasOne('App\Card', 'user_id');
    }

    public function country(){
        return $this->belongsTo('App\Country', 'country_code', 'code');
    }

    public function event_likes(){
        return $this->hasMany('App\EventLike', 'user_id');
    }

    public function education(){
        return $this->hasMany('App\Education', 'user_id');
    }

    public function is_admin(){
        if($this->is_admin && $this->usertype == 'ADMIN'){
            return 1;
        }
    }

    public function is_user(){
        if($this->usertype == 'USER'){
            return 1;
        }
    }

    public function is_manager(){
        if($this->usertype == 'MANAGER'){
            return 1;
        }
    }

}
