<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueType extends Model
{
	protected $primaryKey = 'queue_type_id';

    public function users()
    {
    	return $this->hasMany('App\User', 'queue_type_id', 'queue_type_id');
    }

    public function statistics()
    {
    	return $this->hasMany('App\Statistic', 'queue_type_id', 'queue_type_id');
    }
}
