<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enrollment;
use App\Activity_preference;
use App\Ticket;

class Participant extends Model
{

	protected $dates = [
		'created_at',
		'updated_at',
		'birthday'
	];

    public function enrollment()
    {
    	return $this->belongsTo(Enrollment::class);
    }

    public function activity_preference()
    {
        return $this->hasOne(Activity_preference::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->orderBy('round');
    }

    public function getIsAdultAttribute()
    {
    	return ($this->birthday->age >= 18);
    }
}
