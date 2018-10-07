<?php

namespace App\Jobs;

use App\Repositories\SloganRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UserUpdate
 * @package App\Jobs
 */
class SloganUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @param $inputs
     * @internal param $id
     * @internal param $userID
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @param SloganRepository $sloganRepository
     * @return void
     */
    public function handle(SloganRepository $sloganRepository)
    {
       /*
       |--------------------------------------------------------------------------
       | Initialisation du job
       |--------------------------------------------------------------------------
       */
        $idLog = initJob($this->inputs['user_id'], 'Edition', 'User', $this->inputs['id']);

        $slogan = $sloganRepository->getSloganByID($this->inputs['id']);

        $message = 'Slogan : ' . $this->inputs['message'];
        saveLogMessage($idLog, $message);
        $slogan->message = $this->inputs['message'];

        $message = 'Source : ' . $this->inputs['source'];
        saveLogMessage($idLog, $message);
        $slogan->source = $this->inputs['source'];

        $message = 'URL : ' . $this->inputs['url'];
        saveLogMessage($idLog, $message);
        $slogan->url = $this->inputs['url'];

        $slogan->save();

        endJob($idLog);
    }
}
