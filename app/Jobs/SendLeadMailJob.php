<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\LeadMail;
 
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
class SendLeadMailJob implements ShouldQueue
{    

   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lead;
    public $email;

    public function __construct($lead, $email)
    {
        $this->lead = $lead;
        $this->email = $email;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new LeadMail($this->lead));
    }
}
