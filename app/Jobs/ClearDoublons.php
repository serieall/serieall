<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Artist;
use App\Models\Temp;
use App\Models\Season;
use App\Models\Episode;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client;

use \Illuminate\Support\Str;

/**
 * Class ShowUpdateFromTVDB
 * @package App\Jobs
 */
class ClearDoublons extends Job implements ShouldQueue
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
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob(null, 'Clear Doublons', 'Show', 0 );
        $idLogListUpdateManually = initJob(null, 'List of doublons', 'Show', 0 );

        $allShows = Show::all();
//        $allShows = Show::where('id', '=', 370)->first();

        saveLogMessage($idLog, 'Retrieving All Shows Ok');

        foreach ($allShows as $currentShow) {

            saveLogMessage($idLog, '> Parse current show  : ' . $currentShow);

            $this->processSeasonForShow($currentShow, $idLog, $idLogListUpdateManually);
        }


        /*
        |--------------------------------------------------------------------------
        | End Log
        |--------------------------------------------------------------------------
        */
        endJob($idLog);
        endJob($idLogListUpdateManually);
    }

    /**
     * Remove season doublons for given show
     * @param $currentShow
     */
    private function processSeasonForShow($currentShow, $idLog, $idLogListUpdateManually){
//Retrieve all seasons from the serie with no tvdb id
        $allSeasonsForShow = Season::where('show_id', '=', $currentShow->id)
            ->where('thetvdb_id', null)
            ->get();

        if (is_null($allSeasonsForShow)) {
            saveLogMessage($idLog, '> Retrieving All Seasons for show KO - ' . $currentShow->name);
        } else {
            saveLogMessage($idLog, '> Retrieving All Seasons for show Ok - ' . $currentShow->name . ' : ' . $allSeasonsForShow);

            foreach ($allSeasonsForShow as $currentSeason) {
                saveLogMessage($idLog, '>> Parse current season  : ' . $currentSeason);

                //Is there a season with tvdb id in database ?
                $tvdbSeason = Season::where('show_id', '=', $currentShow->id)
                    ->where('thetvdb_id', '!=', null)
                    ->where('name', '=', $currentSeason->name)
                    ->first();

                if (!is_null($tvdbSeason)) {
                    saveLogMessage($idLog, '>> Season with tvdb id in database  : ' . $tvdbSeason);

                    if ($tvdbSeason->nbnotes > 0) {
                        //Episodes dans la saison noté => ne pas toucher automatiquement, préféré une modification manuelle.
                        saveLogMessage($idLog, '>> Season with rates - process manual update');
                        saveLogMessage($idLogListUpdateManually, '' . $currentShow->name . ' - ' . $currentSeason->name);
                    } else {
                        saveLogMessage($idLog, '>> No rates - automatic correction');

                        $this->updateSeasonData($currentSeason, $tvdbSeason);

                        //Clear doublons and save new one
                        try {
//                            $tvdbSeason->delete();
//                            $currentSeason->save();

                            saveLogMessage($idLog, '>> Delete tvdb season / save current OK');
                        } catch (\Exception $e) {
                            saveLogMessage($idLog, '>> Delete tvdb season / save current KO : ' . $e);
                        }

                    }

                } else {
                    saveLogMessage($idLog, '>> No Season with tvdb id found in database');
                }


            }

        }
    }

    /**
     * Copy data from $seasonToKeepDataFrom to $seasonToUpdate
     * @param $seasonToUpdate
     * @param $seasonToKeepDataFrom
     */
    private function updateSeasonData($seasonToUpdate, $seasonToKeepDataFrom){
        $seasonToUpdate->thetvdb_id = $seasonToKeepDataFrom->thetvdb_id;
    }
}