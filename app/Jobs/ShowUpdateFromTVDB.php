<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Temp;
use ErrorException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Class ShowUpdateFromTVDB
 * @package App\Jobs
 */
class ShowUpdateFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * ShowUpdateFromTVDB constructor.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('ShowUpdateFromTVDB: Start a job.');

        $lastUpdate = Temp::where('key', 'last_update')->first();
        $lastUpdate = $lastUpdate->value;
        // Set time of next update to lastupdate as a base
        $nextUpdate = $lastUpdate;

        try {
            $listUpdate = apiTvdbGetListUpdate($lastUpdate);
        } catch (GuzzleException | ErrorException $e) {
            Log::error('ShowUpdateFromTVDB: Impossible to get list of updates.');
        }

        $listUpdate = $listUpdate->data;

        foreach ($listUpdate as $show) {
            $inputs = array(
                'thetvdb_id' => $show->id
            );

            // Update value of next Update if the date of update of this show is greater than $nextupdate
            $showUpdate = $show->lastUpdated;
            if($showUpdate >= $nextUpdate) {
                $nextUpdate = $showUpdate;
            }

            // Update the show if it exists on our BDD
            $showBdd = Show::where('thetvdb_id', $inputs['thetvdb_id'])->first();
            if (!is_null($showBdd)) {
                createorUpdateShow($inputs);
            }
        }

        $deltaLastNext = $nextUpdate - $lastUpdate;

        if($deltaLastNext >= $secondsWeek){
            $nextUpdate = $lastUpdate + $secondsWeek;
        }

        $newUpdate->value = $nextUpdate;
        $newUpdate->save();
        endJob($idLog);

        Log::debug('ShowUpdateFromTVDB: Enf of job.');
    }
}