<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BatchStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $description;

    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $description)
    {
        $this->description = $description;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): BatchStatusMail
    {
        return $this->markdown('mails.batch-status', ['description' => $this->description])
            ->subject($this->title);
    }
}
