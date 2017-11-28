<?php

namespace App\Http\Controllers\Admin;

use App\Term;
use App\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::whereHas('enrollment', function($query){
            $query->where('state', '<', Enrollment::STATE_CANCELED);
        })->get();

        return view('admin.terms.index')
            ->with('terms', $terms);
    }

    public function pay(Term $term)
    {
        $term->state = Term::STATE_PAYED;
        $term->save();
        return redirect()->back();
    }
}
