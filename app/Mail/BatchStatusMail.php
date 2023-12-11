<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BatchStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $batch;

    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $batch)
    {
        $this->batch = $batch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): BatchStatusMail
    {
        return $this->markdown('mails.batch-status', ['batchName' => $this->batch->identifier])
            ->subject($this->title);
    }
}
