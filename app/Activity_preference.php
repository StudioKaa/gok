<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity_preference extends Model
{
    protected $fillable = ['participant_id'];

    public function activity($item)
    {
    	switch ($item) {
    		case 'round_1':
    			return Activity::find($this->round_1) ?? new Activity(['title' => 'geen']);
    			break;

    		case 'round_2':
    			return Activity::find($this->round_2) ?? new Activity(['title' => 'geen']);
    			break;

    		case 'spare':
    			return Activity::find($this->spare) ?? new Activity(['title' => 'geen']);
    			break;

    		default:
    			return null;
    			break;
    	}
    }

    public function parent()
    {
        return Participant::find($this->depends_on);
    }
}
