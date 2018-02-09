<?php

namespace App\Http\Controllers\Admin;

use App\Enrollment;
use App\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class RemindController extends Controller
{
    
    public function show()
    {
        return view('admin.enrollments.remind')
            ->with('enrollments', $this->getLateEnrollments());
    }

    public function send()
    {
        foreach ($this->getLateEnrollments() as $enrollment)
        {
            Mail::to($enrollment->cp_email)->send(new \App\Mail\PaymentReminder($enrollment, $enrollment->paymentLines()));
        }

        return 'done!';
    }

    private function getLateEnrollments()
    {
        if(time() < strtotime('01 February'))
        {
            return false;
        }

        $late = Enrollment::where('state', Enrollment::STATE_ENROLLED);
        $late = $late->whereHas('terms', function($query){

            $query->where('state', Term::STATE_OPEN);

            if(time() <= strtotime('01 May'))
            {
                $query->where('date', '1 februari');
            }

        })->get();

        
        return $late;
    }

}
