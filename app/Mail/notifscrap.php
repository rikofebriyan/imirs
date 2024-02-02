<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notifscrap extends Mailable
{
    use Queueable, SerializesModels;
    public $dataSend;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataSend)
    {
        $this->dataSend = $dataSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('pe-digitalization4@outlook.com', 'PE-Digitalization-' . Str::random(20))
            ->subject('Task removed successfully - ' . $this->dataSend['subject'])
            ->view('emails.notifScrap');
    }
}
