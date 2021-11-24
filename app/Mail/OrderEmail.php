<?php

namespace App\Mail;

use App\Models\Hmo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Hmo $hmo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Hmo $hmo)
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
        return $this->subject('Your Orders for ' . now()->subMonth()->englishMonth . ' have been processed.')
            ->view('orders.email');
    }
}
