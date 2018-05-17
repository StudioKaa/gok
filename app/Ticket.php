<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Ticket extends Model
{
    
	public function activity()
	{
		return $this->belongsTo(Activity::class);
	}

}
