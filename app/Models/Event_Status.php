<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Status extends Model
{
    use HasFactory;
	protected $table = "event_status";
	
	/**
     * Get the events that have a specific status (e.g. 1, i.e. Pending )
     */
    public function events()
    {
		return $this->hasMany('App\Models\Event','event_status_id','id');  // foreign_key in events table, primary key in event_status table 
		//return $this->hasMany('App\Models\Comment', 'foreign_key', 'local_key');
    }
	
}
