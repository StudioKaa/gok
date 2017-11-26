<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enrollment;

class Participant extends Model
{

	protected $dates = [
		'created_at',
		'updated_at',
		'birthday'
	];

    public function Enrollment()
    {
    	return $this->belongsTo(Enrollment::class);
    }
}
