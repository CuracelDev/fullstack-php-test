<?php

namespace App\Jobs;

use App\Models\Hmo;
use App\Mail\OrderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NotifyHmoOfOrderCompletion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Hmo $hmo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Hmo $hmo)
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
        $mail = new OrderEmail($this->hmo);

        Mail::to($this->hmo->email)->send($mail);
    }
}
