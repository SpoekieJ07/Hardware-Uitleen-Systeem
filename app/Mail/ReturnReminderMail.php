<?php

namespace App\Mail;

use App\Models\Uitleen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Uitleen $loan;

    public function __construct(Uitleen $loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('Herinnering: lever je geleende item op tijd in')
            ->view('emails.return-reminder');
    }
}
