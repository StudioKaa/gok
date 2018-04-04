<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Enrollment;
use App\Participant;
use App\Term;
use App\Activity_preference;
use Illuminate\Http\Request;
use Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('activities.index')->with('activities', $activities);
    }

    public function enroll()
    {
    	$enrollment = Auth::user()->enrollment;
    	$adults = $enrollment->participants()->whereDate('birthday', '<=', '2000-06-02')->get();
    	$kids = $enrollment->participants()->whereDate('birthday', '>', '2000-06-02')->get();

    	return view('activities.enroll')
    		->with('enrollment', $enrollment)
    		->with('adults', $adults)
    		->with('kids', $kids)
    		->with('activities', Activity::all());
    }

    public function save(Request $request)
    {
    	$enrollment = Enrollment::find($request->enrollment);
    	$enrollment->arrival = $request->arrival;
    	$enrollment->save();

    	$payment = 0;
        $dependencies = $request->dep ?? array();

    	foreach ($request->pref as $participant => $pref)
    	{
    		//skip this one if it has a parent itself
    		if(array_key_exists($participant, $dependencies)) break;

    		$preference = Activity_preference::firstOrNew(['participant_id' => $participant]);
    		$preference->participant_id = $participant;
    		$preference->round_1 = $pref[1];
    		$preference->round_2 = $pref[2];
    		$preference->spare = $pref[3];
    		$preference->save();
    	}

    	foreach ($dependencies as $participant => $depends_on)
    	{
    		//prevent double dependencies
    		if(array_key_exists($depends_on, $request->dep))
    		{
    			$depends_on = $request->dep[$depends_on];
    		}

    		$preference = Activity_preference::firstOrNew(['participant_id' => $participant]);
    		$preference->participant_id = $participant;
    		$preference->depends_on = $depends_on;
    		$preference->round_1 = $request->pref[$depends_on][1];
    		$preference->round_2 = $request->pref[$depends_on][2];
    		$preference->spare = $request->pref[$depends_on][3];
    		
    		$preference->save();
    	}

    	return redirect()->route('activities.show');
    }

    public function show()
    {
    	$enrollment = Auth::user()->enrollment;

    	if(!$enrollment->arrival)
    	{
    		return redirect()->route('activities.enroll');
    	}

    	$payment = array();
    	$total = 0;
    	foreach($enrollment->participants as $participant)
    	{
    		if($participant->activity_preference)
    		{
    			$round_1 = $participant->activity_preference->activity('round_1');
    			$round_2 = $participant->activity_preference->activity('round_2');

    			if($round_1->price)
    			{
    				$payment[] = ["{$round_1->title} - {$participant->name}", $round_1->price];
    				$total += $round_1->price;

    			}
    			if($round_2->price)
    			{
    				$payment[] = ["{$round_2->title} - {$participant->name}", $round_2->price];
    				$total += $round_2->price;
    			}
    		}
    	}

    	return view('activities.show')->with('enrollment', $enrollment)->with('payment', $payment)->with('total', $total);
    }
}
