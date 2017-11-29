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

    private $enrollment;
    private $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enrollment, $payment)
    {
        $this->enrollment = $enrollment;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $base64 = base64_encode(json_encode(array(
            'slug' => $this->enrollment->slug,
            'email' => $this->enrollment->cp_email
        )));

        return $this->subject('Scouting Raamsdonksveer - Inschrijving G.O.K.')
            ->cc('gok@scoutingrveer.nl')
            ->replyTo('gok@scoutingrveer.nl', 'Team GOK')
            ->view('enrollments.email')
            ->with('payment', $this->payment)
            ->with('enrollment', $this->enrollment)
            ->with('base64', $base64);
    }
}
