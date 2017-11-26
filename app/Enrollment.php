<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Participant;
use App\User;
use App\Address;
use App\Term;
use Auth;

class Enrollment extends Model
{
    const STATE_FILL_PARTICIPANTS = 0;
    const STATE_FILL_CONTACT = 1;
    const STATE_FILL_PAYMENT = 2;
    const STATE_ENROLLED = 3;
    const STATE_CANCELED = 4;
    const STATE_ARCHIVED = 5;

    public function participants()
    {
    	return $this->hasMany(Participant::class);
    }

    public function cp()
    {
        return Participant::find($this->cp_participant_id);
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    public static function getBySlug($slug)
    {
        if($slug == 'my' || Auth::user()->enrollment->slug == $slug)
        {
            return Auth::user()->enrollment;
        }
        elseif(Auth::user()->type == 'admin')
        {
            return Enrollment::where('slug', $slug)->first();
        }
        
        return false;
    }
}
