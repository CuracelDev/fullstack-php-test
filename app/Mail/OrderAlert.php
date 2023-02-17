<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderAlert extends Mailable {

    use Queueable,
	SerializesModels;

    public $total;  // order total
    public $hmo_name;
    public $provider_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($total, $hmo_name, $provider_name)
    {
	$this->total = $total;
	$this->hmo_name = $hmo_name;
	$this->provider_name = $provider_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

public function build()
{
    return $this->view('emails.order_received');
}



}
