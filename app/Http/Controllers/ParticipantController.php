<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;
use App\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Member;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $slug, $n)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

        return view('participants.create')
            ->with('enrollment', $enrollment)
            ->with('n', $request->session()->get('participants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($slug, Request $request)
    {
        $this->validate(request(), [
            'participants.*.name' => 'required|string',
            'participants.*.birthday' => 'required|date_format:d-m-Y',
            'cp' => 'required|integer'
        ]);

        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');
        
        foreach($request->participants as $i => $p)
        {
            $participant = new Participant();
            $participant->enrollment_id = $enrollment->id;
            $participant->is_member = isset($p['member']) ? true : false;
            $participant->name = $p['name'];
            $participant->birthday = date('Y-m-d', strtotime($p['birthday']));
            $participant->diet = $p['diet']; 
            
            //set member_id if applicable
            if($participant->is_member)
            {
                $member = Member::whereDate('Lid geboortedatum', $participant->birthday)->get();
                if($member->count() == 1)
                {
                    $participant->member_id = $member->first()->Lidnummer;
                }
            }

            $participant->save();

            //set cp_participant_id on enrollment
            if($i == $request->cp)
            {
                $enrollment->cp_participant_id = $participant->id;
                
            }
            $enrollment->state = Enrollment::STATE_FILL_CONTACT;
            $enrollment->save();
        }

        return redirect()->route('enrollments.contact', $enrollment->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant)
    {
        //
    }
}
