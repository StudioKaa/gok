<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Enrollment;
use Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'action']);
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login_form(Request $request)
    {
        $this->validate(request(), [
            'slug' => 'required|integer',
            'email' => 'required|email'
        ]);

        return $this->login($request->slug, $request->email);
    }

    public function login_decode($base64, $action = null)
    {
        $data = json_decode(base64_decode($base64));
        return $this->login($data->slug, $data->email, $action);
    }

    private function login($slug, $email, $action = null)
    {

        $enrollment = Enrollment::where('slug', $slug)->first();
        if(!$enrollment)
        {
            return redirect()->back()->withErrors('Inschrijving niet gevonden.');
        }

        if($enrollment->cp_email != $email)
        {
            return redirect()->back()->withErrors('E-mailadres niet gevonden.');
        }

        Auth::login($enrollment->user);

        switch ($action) {
            case 'pay':
                return redirect()->route('ideal.pay', $enrollment->terms[0]->slug);
                break;
            
            default:
                return redirect()->intended();
                break;
        }
    }

    public function action($action, $slug)
    {
        $enrollment = Enrollment::where('slug', $slug)->first();
        Auth::login($enrollment->user);

        switch ($action) {
            case 'activities':
                return redirect()->route('activities.enroll');
                break;
            
            default:
                return redirect()->intended();
                break;
        }
    }
}
