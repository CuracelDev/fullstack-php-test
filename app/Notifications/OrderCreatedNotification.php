<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public readonly string $batchName,
        public readonly string $provider,
        public readonly string $hmoName
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Hello $this->hmoName,")
            ->line(
                new HtmlString("<p>An order has been created by <strong>$this->provider</strong>.
                    This is the batch Identifier: <strong>$this->batchName</strong></p>")
            )
            ->action('View Order', config('app.url'))
            ->line('Thank you, for using ' . config('app.name') . ',');
    }
}
