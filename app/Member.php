<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Participant;
use App\Enrollment;

class Member extends Model
{
    protected $primaryKey = 'Lidnummer';

    public function participant()
    {
    	return $this->hasOne(Participant::class, 'member_id');
    }

    public function hasCompleteEnrollment()
    {
    	if($this->enrollment != null)
    	{
    		if($this->enrollment->state == Enrollment::STATE_ENROLLED)
			{
				return true;
			}
    	}

    	return false;
    }

    public function getEnrollment()
    {
    	if($this->participant != null)
    	{
    		return $this->participant->enrollment;
    	}

    	return null;
    }

    public function __get($key)
    {
    	if($key == 'enrollment')
		{
			return $this->getEnrollment();
		}
		
		return $this->getAttribute($key);
    }
}
	