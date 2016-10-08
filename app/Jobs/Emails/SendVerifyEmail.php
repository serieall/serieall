<?php

namespace App\Jobs\Emails;


use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Job as Job;


class SendVerifyEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $userEmail;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($userEmail, $token)
    {
        $this->userEmail = $userEmail;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('auth.emails.verify', ['data'=>'data'], function ($message) {
            $message->subject('Test');
            $message->from('journeytotheit@gmail.com', 'Série-All');
            $message->to($this->userEmail);
        });
    }
}