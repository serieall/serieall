<?php

namespace App\Jobs;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class New_ShowAddFromTVDB
 * @package App\Jobs
 */
class New_ShowAddFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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

    public function handle()
    {
        # Init Job's logs
        $logID = initJob($this->inputs['user_id'], 'Ajout via TVDB', 'Show', $this->inputs['thetvdb_id']);

        # Init variables
        $theTvdbId = $this->inputs['thetvdb_id'];
        $public = public_path();

        # Now, we are getting the informations from the Show, in english and in french
        $showFr = apiTvdbGetShow('fr', $theTvdbId);
        $showEn = apiTvdbGetShow('en', $theTvdbId);

    }
}
