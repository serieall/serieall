<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class AddShowFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $show_tvdbid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($show_tvdbid)
    {
        $this->show_tvdbid = $show_tvdbid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client(['base_uri' => 'https://api.thetvdb.com/']);

        $token = $client->request('POST', '/login', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => [
                'apikey' => '64931690DCC5FC6B',
                'username' => 'Youkoulayley',
                'userkey' => '6EE6A1F4BF0DDA46'
            ]
        ]);

        dd($token);
    }
}
