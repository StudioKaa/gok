<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = ['id'];

    public function prettyPrice()
    {
    	if($this->price == null) return 'gratis';
    	return '&euro;' . $this->price;
    }

    public function prettyDuration()
    {
    	$word = $this->duration == 1 ? 'ronde' : 'rondes';
    	$time = $this->duration * 2;
    	return "{$this->duration} $word ($time uur)";
    }
}
