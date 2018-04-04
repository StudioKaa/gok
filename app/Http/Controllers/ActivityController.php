<?php

namespace App\Http\Controllers;

use App\Activity;
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
    	return Auth::user()->enrollment;
    }
}
