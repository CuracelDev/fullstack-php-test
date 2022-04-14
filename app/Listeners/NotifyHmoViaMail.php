<?php

namespace App\Listeners;

use App\Events\OrderStored;
use App\Mail\OrderStoredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyHmoViaMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderStored  $event
     * @return void
     */
    public function handle(OrderStoredMail $event)
    {
        Mail::to($event->order->hmo->email)->send(new OrderStored($event->order));
    }
}
