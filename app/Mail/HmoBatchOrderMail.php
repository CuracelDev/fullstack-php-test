<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HmoBatchOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    private Order $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->markdown('emails.hmo.batch-order', [
                'orderUrl' => $this->generateOrderUrl()
            ]);
    }

    protected function generateOrderUrl(): string
    {
        return config('app.url') . "/orders/" . $$this->order->id;
    }
}
