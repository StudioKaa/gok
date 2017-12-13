<?php

namespace App\Http\Controllers;

use App\Enrollment;
use Illuminate\Http\Request;
use App\User;
use App\Address;
use App\Member;
use App\Term;
use Illuminate\Support\Facades\Auth;
use Mail;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function create()
    {
        return view('enrollments.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'equipment' => 'required',
            'participants' => 'required',
            'equipment_size' => 'present'
        ]);

        $enrollment = new Enrollment();
        $enrollment->state = Enrollment::STATE_FILL_PARTICIPANTS;
        $enrollment->equipment = $request->equipment;
        $enrollment->equipment_size = $request->equipment_size;
        $enrollment->save();

        $enrollment->slug = sprintf("%02d%03d", rand(10,99), $enrollment->id);
        $enrollment->save();

        $user = new User();
        $user->name = "Inschrijving #GOK".$enrollment->slug;
        $user->username = "GOK".$enrollment->slug;
        $user->password = password_hash($enrollment->slug.rand(100, 999), PASSWORD_BCRYPT);
        $user->enrollment_id = $enrollment->id;
        $user->save();
        Auth::login($user);

        $request->session()->put('participants', $request->participants);
        return redirect()->route('participants.create', [$enrollment->slug, $request->participants]);
    }

    public function continue(Request $request, $slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

        switch ($enrollment->state) {
            case Enrollment::STATE_FILL_PARTICIPANTS:
                return redirect()->route('participants.create', [$slug, $request->session()->get('participants')]);
                break;
            
            case Enrollment::STATE_FILL_CONTACT:
                return redirect()->route('enrollments.contact', $slug);
                break;

            case Enrollment::STATE_FILL_PAYMENT:
                return redirect()->route('enrollments.payment', $slug);
                break;

            case Enrollment::STATE_ENROLLED:
                return redirect()->route('enrollments.show', $slug);
                break;

            default:
                return redirect()->route('home');
                break;
        }
    }

    public function contact($slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment || $enrollment->state != Enrollment::STATE_FILL_CONTACT) return redirect('home');

        $address = new Address();

        //Find address
        $member = Member::find($enrollment->participants()->whereNotNull('member_id')->first());
        if($member)
        {
            $member = $member->first();
            //Set title on address
            if(count($enrollment->participants) == 1)
            {
                $address->title = $enrollment->cp()->name;
            }
            else
            {
                $address->title = 'Familie ';
                $address->title .= empty($member->{'Lid tussenvoegsel'}) ? '' : $member->{'Lid tussenvoegsel'} . ' ';
                $address->title .= $member->{'Lid achternaam'};
            }

            // //Set address (MAJOR PRIVACY CONCERN)
            // $address->street = $member->{'Lid straat'} . ' ' . $member->{'Lid huisnummer'} . $member->{'Lid toevoegsel huisnr'};;
            // $address->postal_code = $member->{'Lid postcode'};
            // $address->city = $member->{'Lid plaats'};
        }

        return view('enrollments.contact')
            ->with('enrollment', $enrollment)
            ->with('address', $address);
    }

    public function contact_save(Request $request, $slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment || $enrollment->state != Enrollment::STATE_FILL_CONTACT) return redirect('home');

        $this->validate(request(), [
            'cp_email' => 'required|email',
            'cp_phone' => 'required|string|size:10',
            'title' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
        ]);

        $enrollment->cp_email = $request->cp_email;
        $enrollment->cp_phone = $request->cp_phone;
        $enrollment->state = Enrollment::STATE_FILL_PAYMENT;
        $enrollment->save();

        $address = new Address();
        $address->enrollment_id = $enrollment->id;
        $address->title = $request->title;
        $address->street = $request->street;
        $address->postal_code = $request->postal_code;
        $address->city = $request->city;
        $address->save();

        return redirect()->route('enrollments.payment', $enrollment->slug);
    }

    public static function paymentLines($enrollment)
    {
        return $enrollment->paymentLines();
    }

    public function payment($slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment || $enrollment->state != Enrollment::STATE_FILL_PAYMENT) return redirect('home');

        return view('enrollments.payment')
            ->with('payment', $this->paymentLines($enrollment))
            ->with('enrollment', $enrollment);
    }

    public function payment_save(Request $request, $slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment || $enrollment->state != Enrollment::STATE_FILL_PAYMENT) return redirect('home');

        $this->validate(request(), [
            'terms' => 'required|between:1,2',
            'method' => 'required'
        ]);

        $payment = $this->paymentLines($enrollment);
        $total = $payment['total'];

        if($request->terms == 1)
        {
            $term = new Term();
            $term->enrollment_id = $enrollment->id;
            $term->amount = $total;
            $term->date = '1 februari';
            $term->save();

            $term->slug = $enrollment->slug . '-1';
            $term->save();
        }
        elseif($request->terms == 2)
        {
            $term1 = new Term();
            $term1->enrollment_id = $enrollment->id;
            $term1->amount = floor($total/2);
            $term1->date = '1 februari';
            $term1->save();
            $term1->slug = $enrollment->slug . '-1';
            $term1->save();

            $term2 = new Term();
            $term2->enrollment_id = $enrollment->id;
            $term2->amount = ceil($total/2);
            $term2->date = '1 mei';
            $term2->save();
            $term2->slug = $enrollment->slug . '-2';
            $term2->save();
        }

        $enrollment->state = Enrollment::STATE_ENROLLED;
        $enrollment->save();
        

        if($request->method == 'ideal')
        {
            $request->session()->put('finished', 'ideal');
            return redirect()->route('ideal.pay', $enrollment->terms[0]->slug);
        }

        $request->session()->put('finished', 'bank');
        return redirect()->route('enrollments.show', $enrollment->slug);
    }
    
    public function show(Request $request, $slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment || $enrollment->state < Enrollment::STATE_ENROLLED) return redirect('home');

        $payment = $this->paymentLines($enrollment);
        $finished = false;

        if($request->session()->has('finished'))
        {
            $finished = $request->session()->get('finished');
            Mail::to($enrollment->cp_email)->send(new \App\Mail\EnrollmentComplete($enrollment, $payment));
            $request->session()->forget('finished');
        }

        return view('enrollments.show')
            ->with('payment', $payment)
            ->with('finished', $finished)
            ->with('enrollment', $enrollment);
    }
}