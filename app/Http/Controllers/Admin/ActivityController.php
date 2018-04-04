<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::all();
        return view('admin.activities.index')->with('activities', $activities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.form')->with('activity', new Activity());
    }

    private function fix_data(Request $request)
    {
        $this->validate($request, [
            'order' => 'required|integer',
            'title' => 'required',
            'duration' => 'required|in:1,2',
            'price' => 'nullable|numeric',
            'age' => 'required',
            'location_generic' => 'required',
            'description' => 'required',
            'image' => 'image|nullable'
        ]);

        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['order' => 'unique:activities', 'image' => 'required|image']);
        $request = $this->fix_data($request);
        $activity = Activity::create($request->all());

        $path = $request->image->store('activities', 'public');
        $activity->image = 'storage/' . $path;
        $activity->save();

        return redirect()->route('admin.activities.index')
            ->with('status', ['success', 'Activiteit <strong>' . $activity->title . '</strong> toegevoegd!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.form')->with('activity', $activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $request = $this->fix_data($request);
        $activity->fill($request->all());
        
        if ($request->hasFile('image'))
        {
            $path = $request->image->store('activities', 'public');
            $activity->image = 'storage/' . $path;
        }

        $activity->save();
        return redirect()->route('admin.activities.index')
            ->with('status', ['success', 'Activiteit <strong>' . $activity->title . '</strong> opgeslagen!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!is_array($request->delete))
        {
            return redirect()->back()->with('status', ['danger', 'Geen rijen geselecteerd']);
        }

        foreach($request->delete as $id)
        {
            $activity = Activity::find($id);
            $activity->delete();
        }

        return redirect()->route('admin.activities.index')->with('status', ['success', count($request->delete) . ' rijen verwijderd']);
    }
}
