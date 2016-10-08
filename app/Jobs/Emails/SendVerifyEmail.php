<?php

namespace App\Jobs\Emails;


use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Job as Job;


class SendVerifyEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $userEmail;
    protected $userUsername;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($userEmail, $userUsername, $token)
    {
        $this->userEmail = $userEmail;
        $this->token = $token;
        $this->userUsername = $userUsername;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = $this->token;
        $userEmail = $this->userEmail;
        $userUsername = $this->userUsername;

        Mail::send('auth.emails.verify', compact('userEmail', 'userUsername', 'token'), ['data'=>'data'], function ($message) {
            $message->subject('Vérification de votre adresse E-Mail');
            $message->from('journeytotheit@gmail.com', 'Série-All');
            $message->to($this->userEmail);
        });
    }
}