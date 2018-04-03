<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = ['id'];

    public function getPriceAttribute($value)
    {
    	if($value == null) return 'gratis';
    	return '&euro;' . $value;
    }

    public function getDurationAttribute($value)
    {
    	$word = $value == 1 ? 'ronde' : 'rondes';
    	$time = $value * 2;
    	return "$value $word ($time uur)";
    }
}
