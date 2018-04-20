<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use URL;

class ActivityRemind extends Mailable
{
    use Queueable, SerializesModels;

    private $enrollment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = URL::signedRoute('action', ['activities', $this->enrollment->slug]);

        return $this->subject('G.O.K. - Herinnering aanmelden keuze-activiteiten')
            ->replyTo('gok@scoutingrveer.nl', 'Team GOK')
            ->view('activities.email_remind')
            ->with('enrollment', $this->enrollment)
            ->with('cp', $this->enrollment->cp())
            ->with('link', $link);
    }
}
