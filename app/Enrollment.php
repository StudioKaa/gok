<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Participant;
use App\User;
use App\Address;
use App\Term;
use Auth;
use Carbon\Carbon;

class Enrollment extends Model
{
    const STATE_FILL_PARTICIPANTS = 0;
    const STATE_FILL_CONTACT = 1;
    const STATE_FILL_PAYMENT = 2;
    const STATE_ENROLLED = 3;
    const STATE_CANCELED = 4;
    const STATE_ARCHIVED = 5;

    protected $appends = ['stateHTML', 'paymentHTML'];

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
        if(Auth::user()->admin)
        {
            return Enrollment::where('slug', $slug)->first();
        }
        elseif($slug == 'my' || Auth::user()->enrollment->slug == $slug)
        {
            return Auth::user()->enrollment;
        }
        else
        
        return false;
    }

    public function getStateHTMLAttribute()
    {
        switch ($this->state) {
            case Enrollment::STATE_FILL_PARTICIPANTS:
                return array(
                    'color' => 'warning',
                    'title' => 'Vul deeln in'
                );
                break;

            case Enrollment::STATE_FILL_CONTACT:
                return array(
                    'color' => 'warning',
                    'title' => 'Vul cp in'
                );
                break;

            case Enrollment::STATE_FILL_PAYMENT:
                return array(
                    'color' => 'warning',
                    'title' => 'Vul betaling in'
                );
                break;
            
            case Enrollment::STATE_ENROLLED:
                return array(
                    'color' => 'success',
                    'title' => 'Aangemeld'
                );
                break;

            case Enrollment::STATE_CANCELED:
                return array(
                    'color' => 'danger',
                    'title' => 'Geannuleerd'
                );
                break;

            case Enrollment::STATE_ARCHIVED:
                return array(
                    'color' => 'secondary',
                    'title' => 'Gearchiveerd'
                );
                break;

            default:
                return array(
                    'color' => 'secondary',
                    'title' => 'Onbekend'
                );
                break;
        }
    }

    public function getPaymentHTMLAttribute()
    {
        $count['open'] = count($this->terms->where('state', Term::STATE_OPEN));
        $count['payed'] = count($this->terms->where('state', Term::STATE_PAYED));

        if(!$count['payed'])
        {
            return array(
                'color' => 'danger',
                'title' => 'Open'
            );
        }
        elseif($count['payed'] > 0 && $count['open'] > 0)
        {
            return array(
                'color' => 'warning',
                'title' => 'Gestart'
            );
        }
        elseif($count['payed'] >= 1 && $count['open'] < 1)
        {
            return array(
                'color' => 'success',
                'title' => 'Betaald'
            );
        }
        else{
            return array(
                'color' => 'secondary',
                'title' => 'Onbekend'
            );
        }
    }

    public function paymentLines()
    {
        $lines = array();
        $total = 0;

        foreach($this->participants()->whereDate('birthday', '<', '2014-06-01')->get() as $p)
        {
            $lines[] = array(
                'name' => "{$p->name} ({$p->birthday})",
                'price' => '35'
            );
            $total += 35;
        }

        foreach($this->participants()->whereDate('birthday', '>=', '2014-06-01')->get() as $p)
        {
            $lines[] = array(
                'name' => "{$p->name} ({$p->birthday})",
                'price' => '15'
            );
            $total += 15;
        }

        if($this->equipment == 'hire')
        {
            $lines[] = array(
                'name' => "Tent huren",
                'price' => '15'
            );
            $total += 15;
        }

        if($this->created_at < new Carbon('2018-03-01'))
        {
            $lines[] = array(
                'name' => "Gratis muntje voor early-bird",
                'price' => '0'
            );
        }

        return array(
            'total' => $total,
            'lines' => $lines
        );
    }
}
