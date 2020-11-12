<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','start','end','user_id','description','date','repeat_event_id'
    ];
	
	
	/**
     * Get the event_status record associated with the user.
     */
    public function event_status()
    {
        return $this->hasOne('App\Models\Event_Status','id','event_status_id');   // model, foreign_key (in event_status table), local key in the events table
    }
	
}
