<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Hmo $hmo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hmo)
    {
        $this->hmo = $hmo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(
            'Your Orders for ' 
            . now()->subMonth()->englishMonth 
            . ' have been processed.'
        )
            ->view('orders.email');
    }
}
