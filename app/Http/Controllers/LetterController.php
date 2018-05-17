<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Enrollment;

class LetterController extends Controller
{
    public function invites()
    {
    	$excluded = array(
    		167402741,	//Bart R
    		167402565,	//Harvey
    		600898331,	//Jordi
    		151000553, 	//Gaby
    		167200220,	//Twan
    		167400453,	//Melanie
    		170900026, 	//Wilco
    		600258868, 	//Cathelina
    		600628468, 	//Myrthe
    		601390163,	//Kevin de Graaf
    		601384817, 	//Tim in 't Groen
    		601435230, 	//Arie
    		601518368, 	//Patrick
    		601637839, 	//Ticho de Graaf
    		601825081, 	//Angela
    		601986759, 	//Robbin
    		602253707, 	//Ruud
    		602670200, 	//Stefan
    		602691870, 	//Jolanda
    		602836619, 	//Bianca
    		603207737, 	//Marjolaine
    		603287894, 	//Bouwsma	
    		602228583,	//Egdom
    		603169930,	//Van den Heuvel
    		602094702,	//Rooijackers
    		602660432,	//Schoenmakers
    		603073911,	//Sammie
    		603281129,	//De Waard
    	);

    	$members = Member::whereNotIn('Lidnummer', $excluded)->orderBy('Speleenheid')->get();
    	return view('letters.invite')->with('members', $members);
    }

    public function gids()
    {
        $enrollments = Enrollment::where('state', Enrollment::STATE_ENROLLED)->get();
        return view('letters.gids')->with(compact('enrollments'));
    }
}
