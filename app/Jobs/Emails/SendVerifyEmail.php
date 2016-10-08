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

    protected $user;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = $this->token;
        $userEmail = $this->user->email;
        $userUsername = $this->user->username;

        Mail::send('auth.emails.verify', compact('userEmail', 'userUsername', 'token'), ['data'=>'data'], function ($message) {
            $message->subject('Vérification de votre adresse E-Mail');
            $message->from('journeytotheit@gmail.com', 'Série-All');
            $message->to($userEmail);
        });
    }
}