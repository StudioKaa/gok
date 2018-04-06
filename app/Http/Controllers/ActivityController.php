<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Enrollment;
use App\Participant;
use App\Term;
use App\Activity_preference;
use Illuminate\Http\Request;
use Auth;
use DB;

class ActivityController extends Controller
{
    public function index()
    {
        $q = "
        SELECT * FROM activities LEFT JOIN (
            SELECT activities.id, c.count AS popular FROM activities LEFT JOIN ( 
                SELECT id, COUNT(id) AS count FROM ( 
                    SELECT a.id, a.title, p.participant_id FROM activities AS a LEFT JOIN activity_preferences p ON p.round_1 = a.id WHERE p.id IS NOT NULL
                    UNION
                    SELECT a.id, a.title, p.participant_id FROM activities AS a LEFT JOIN activity_preferences p ON p.round_2 = a.id WHERE p.id IS NOT NULL
                ) AS t GROUP BY id
            ) AS c ON c.id = activities.id ORDER BY count DESC LIMIT 3
        ) AS e ON e.id = activities.id ORDER BY activities.order ASC
        ";

        $activities = Activity::hydrate(DB::select($q));
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

    	return redirect()->route('activities.show')->with('status', ['success', 'Dankjewel, je voorkeuren zijn opgeslagen!']);
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
