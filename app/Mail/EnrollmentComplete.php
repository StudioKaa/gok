<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class EnrollmentComplete extends Mailable
{
    use Queueable, SerializesModels;

    private $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $enrollment = Auth::user()->enrollment;
        if(!$enrollment) return redirect('home');

        return $this->subject('Scouting Raamsdonksveer - Inschrijving G.O.K.')
            ->cc('gok@scoutingrveer.nl')
            ->replyTo('gok@scoutingrveer.nl', 'Team GOK')
            ->view('enrollments.email')
            ->with('payment', $this->payment)
            ->with('enrollment', $enrollment);
    }
}
