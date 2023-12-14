<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderBatchEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $introduction;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $introduction, string $message)
    {
        $this->introduction = $introduction;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.batched', [
            'message' => $this->message,
            'introduction' => $this->introduction
        ]);
    }
}
