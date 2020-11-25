<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'window_number', 'current_regular_queue_number', 'current_pod_queue_number', 'is_currently_serving_regular'
    ];

    protected $appends = ['window', 'current_regular', 'current_pod', 'serving_regular'];

    public function queue_type()
    {
        return $this->belongsTo('App\QueueType', 'queue_type_id', 'queue_type_id');
    }

    //https://stackoverflow.com/questions/43467328/laravel-5-authentication-without-remember-token
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();

        if(!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }

    public function getWindowAttribute()
    {
        return $this->attributes['window_number'];
    }

    public function getCurrentRegularAttribute()
    {
        return $this->attributes['current_regular_queue_number'];
    }

    public function getCurrentPodAttribute()
    {
        return $this->attributes['current_pod_queue_number'];
    }

    public function getServingRegularAttribute()
    {
        return $this->attributes['is_currently_serving_regular'];
    }
}
