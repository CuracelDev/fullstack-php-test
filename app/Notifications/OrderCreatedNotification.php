<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("[Order Created] {$this->order->batch_id}")
            ->greeting("Hello {$this->order->hmo->name},")
            ->line('You have a new order')
            ->action('View Order', url('/'))
            ->line('Regards,')
            ->line(config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
