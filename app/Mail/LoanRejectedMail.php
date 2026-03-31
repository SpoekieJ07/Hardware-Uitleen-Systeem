<?php

namespace App\Mail;

use App\Models\Uitleen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Uitleen $loanRequest;

    public function __construct(Uitleen $loanRequest)
    {
        $this->loanRequest = $loanRequest;
    }

    public function build()
    {
        return $this->subject('Je uitleenaanvraag is afgewezen')
            ->view('emails.loan-rejected');
    }
}