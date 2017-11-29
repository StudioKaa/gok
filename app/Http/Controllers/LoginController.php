<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Enrollment;
use Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

    public function login_base64($base64)
    {
        $data = json_decode(base64_decode($base64));
        $this->login($data->slug, $data->email);
    }

    private function login($slug, $email)
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
        return redirect()->route('enrollments.show', $enrollment->slug);
    }
}
