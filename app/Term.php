<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enrollment;

class Term extends Model
{
    const STATE_OPEN = 0;
    const STATE_PAYED = 1;

    public function enrollment()
    {
    	return $this->belongsTo(Enrollment::class);
    }
}
