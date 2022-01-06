<?php

namespace App\Jobs;

use App\Models\Hmo;
use App\Mail\OrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NotifyHMO implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Hmo $hmo;

    /**
     * Create a new job instance.
     * 
     * @param $hmo 
     *
     * @return void
     */
    public function __construct($hmo)
    {
        $this->hmo = $hmo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new OrderMail($this->hmo);

        Mail::to($this->hmo->email)->send($mail);
    }
}
