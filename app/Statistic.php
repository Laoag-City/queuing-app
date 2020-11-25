<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
	protected $primaryKey = 'stat_id';

	protected $fillable = ['queue_type_id', 'date'];

    public function queue_type()
    {
        return $this->belongsTo('App\QueueType', 'queue_type_id', 'queue_type_id');
    }
}
