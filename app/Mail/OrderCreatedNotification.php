<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class OrderCreatedNotification extends Mailable implements ShouldQueue
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
        return $this->subject("Order successfully submitted: {$this->order->batch_id}")
            ->html(
                (new MailMessage())
                    ->greeting("Hey {$this->order->hmo->name},")
                    ->line("An order has been submitted by {$this->order->provider}. This is the batch ID: {$this->order->batch_id}")
                    ->action('View Order', config('app.url'))
                    ->line('Thank you, for using ' . config('app.name') . ',')
                    ->salutation('The ' . config('app.name') . ' Team')
                    ->line('______________________________')
                    ->line('_This is an automated message, please do not reply_')
                    ->render()
            );
    }
}
