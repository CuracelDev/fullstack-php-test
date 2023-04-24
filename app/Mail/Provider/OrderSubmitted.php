<?php

namespace App\Mail\Provider;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class OrderSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

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
        return $this->subject("New Order Submitted: {$this->order->batch_id}")
            ->html(
                (new MailMessage())
                    ->greeting("Hello {$this->order->hmo->name},")
                    ->line("You just a received a new order from {$this->order->provider}. It has been lodged in the {$this->order->batch_id} batch for your consideration.")
                    ->action('View Order', config('app.url'))
                    ->line('--')
                    ->line('Thank you for using our application,')
                    ->salutation('The Curacel Team')
                    ->render()
            );
    }
}
