<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enrollment;

class Address extends Model
{
    public function enrollment()
    {
    	return $this->belongsTo(Enrollment::class);
    }
}
