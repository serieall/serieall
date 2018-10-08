<?php

namespace App\Jobs;

use App\Models\Slogan;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class SloganStore
 * @package App\Jobs
 */
class SloganStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @param $inputs
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $idLog = initJob($this->inputs['user_id'], 'Ajout Manuel', 'Slogan', mt_rand());

        foreach($this->inputs['slogans'] as $slogan) {
            $sloganNew = new Slogan();
            $logMessage = '>SLOGAN';
            saveLogMessage($idLog, $logMessage);

            $message = 'Slogan : ' . $slogan['message'];
            saveLogMessage($idLog, $message);
            $sloganNew->message = $slogan['message'];

            $message = 'Source : ' . $slogan['source'];
            saveLogMessage($idLog, $message);
            $sloganNew->source = $slogan['source'];

            $message = 'URL : ' . $slogan['url'];
            saveLogMessage($idLog, $message);
            $sloganNew->url = $slogan['url'];

            $sloganNew->save();
        }

        endJob($idLog);
    }
}
