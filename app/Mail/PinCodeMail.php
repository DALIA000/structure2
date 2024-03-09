<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PinCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private $pin_code)
    {
        $this->pin_code = $pin_code;
    }

    public function build(){
        return $this->markdown('mails.pin-code-mail', ['pin_code' => $this->pin_code]);
    }
}
