<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class LetterController extends Controller
{
    public function invites()
    {
    	$members = Member::orderBy('Speleenheid')->get();
    	return view('letters.invite')->with('members', $members);
    }
}
