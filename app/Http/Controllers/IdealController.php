<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Term;
use Mollie;

class IdealController extends Controller
{
    public function redirect($slug)
    {
        $term = Term::where('slug', $slug)->first();

        if($term->state == Term::STATE_OPEN)
    	{
    		 $payment = Mollie::api()->payments()->create([
	            "amount"      => $term->amount + 0.29	,
	            "description" => "Scouting Rveer GOK" . $term->slug,
	            "redirectUrl" => url('ideal/finish/' . $term->slug),
	           	"method"	  => 'ideal',
	           	"metadata" 	  => json_encode([
	           		'term_id' => $term->id
	           	])
	        ]);

	        $term->mollie_id = $payment->id;
	        $term->save();
	  
	        return redirect($payment->links->paymentUrl);
    	}

    	return redirect()->back();

    }

    public function finish(Request $request, $slug)
    {
        $term = Term::where('slug', $slug)->first();
        $payment = Mollie::api()->payments()->get($term->mollie_id);

        if ($payment->isPaid())
        {
            $term->state = Term::STATE_PAYED;
            $term->save();
            $request->session()->flash('ideal_payed');
        }
		elseif($payment->isOpen() || $payment->isPending())
		{
			$request->session()->flash('ideal_pending');
		}
		else
		{
			$request->session()->flash('ideal_error');
		}
        return redirect()->route('enrollments.show', $term->enrollment->slug);
    }

    public function webhook()
    {
    	$payment = Mollie::api()->payments()->get($payment->id);

        if ($payment->isPaid())
        {
            echo "Payment received.";
        }

    	return response('Done', 200);
    }
}
