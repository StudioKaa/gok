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

class EnrollmentController extends Controller
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
    public function create()
    {
        return view('enrollments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('participants.create', [$enrollment->slug, $request->participants]);
    }

    public function contact($slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

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

            //Set address
            $address->street = $member->{'Lid straat'} . ' ' . $member->{'Lid huisnummer'} . $member->{'Lid toevoegsel huisnr'};;
            $address->postal_code = $member->{'Lid postcode'};
            $address->city = $member->{'Lid plaats'};
        }

        return view('enrollments.contact')
            ->with('enrollment', $enrollment)
            ->with('address', $address);
    }

    public function contact_save(Request $request, $slug)
    {
        $this->validate(request(), [
            'cp_email' => 'required|email',
            'cp_phone' => 'required|string|size:10',
            'title' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
        ]);

        $enrollment = Enrollment::getBySlug($slug);
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

    private function paymentLines($enrollment)
    {
        $lines = array();
        $total = 0;

        foreach($enrollment->participants()->whereDate('birthday', '<', '2014-06-01')->get() as $p)
        {
            $lines[] = array(
                'name' => "{$p->name} ({$p->birthday})",
                'price' => '35'
            );
            $total += 35;
        }

        foreach($enrollment->participants()->whereDate('birthday', '>=', '2014-06-01')->get() as $p)
        {
            $lines[] = array(
                'name' => "{$p->name} ({$p->birthday})",
                'price' => '15'
            );
            $total += 15;
        }

        if($enrollment->equipment == 'hire')
        {
            $lines[] = array(
                'name' => "Tent huren",
                'price' => '15'
            );
            $total += 15;
        }

        return array(
            'total' => $total,
            'lines' => $lines
        );
    }

    public function payment($slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

        return view('enrollments.payment')
            ->with('payment', $this->paymentLines($enrollment))
            ->with('enrollment', $enrollment);
    }

    public function payment_save(Request $request, $slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

        $this->validate(request(), [
            'terms' => 'required|between:1,2'
        ]);

        $payment = $this->paymentLines($enrollment);
        $total = $payment['total'];
        $rand = rand(100,999);

        if($request->terms == 1)
        {
            $term = new Term();
            $term->enrollment_id = $enrollment->id;
            $term->amount = $total;
            $term->save();

            $term->slug = sprintf("%03d%03d", $rand, $term->id);
            $term->save();
        }
        elseif($request->terms == 2)
        {
            $term1 = new Term();
            $term1->enrollment_id = $enrollment->id;
            $term1->amount = floor($total/2);
            $term1->save();
            $term1->slug = sprintf("%03d%03d", $rand, $term1->id);
            $term1->save();

            $term2 = new Term();
            $term2->enrollment_id = $enrollment->id;
            $term2->amount = ceil($total/2);
            $term2->save();
            $term2->slug = sprintf("%03d%03d", $rand, $term2->id);
            $term2->save();
        }

        $enrollment->state = Enrollment::STATE_ENROLLED;
        $enrollment->save();

        Mail::to($enrollment->cp_email)->send(new \App\Mail\EnrollmentComplete($payment));

        return redirect()->route('enrollments.finish', $enrollment->slug);
    }

    public function finish($slug)
    {
        $enrollment = Enrollment::getBySlug($slug);
        if(!$enrollment) return redirect('home');

        return view('enrollments.finish')
            ->with('payment', $this->paymentLines($enrollment))
            ->with('enrollment', $enrollment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
