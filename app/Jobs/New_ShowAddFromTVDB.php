<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Show;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    public function handle() : bool
    {
        # Init Job's logs
        $logID = initJob($this->inputs['user_id'], 'Ajout via TVDB', 'Show', $this->inputs['thetvdb_id']);

        # Init variables
        $theTvdbId = $this->inputs['thetvdb_id'];
        $public = public_path();

        # Now, we are getting the informations from the Show, in english and in french
        try {
            $showFr = apiTvdbGetShow('fr', $theTvdbId)->data;
        } catch (GuzzleException $e) {
            Log::error('ShowAddFromTVDB: Show not found for language fr.');
            return false;
        }
        try {
            $showEn = apiTvdbGetShow('en', $theTvdbId)->data;
        } catch (GuzzleException $e) {
            Log::error('ShowAddFromTVDB: Show not found for language en.');
            return false;
        }

        # Define name EN as FR name when EN is not completed on TVDB (french series mostly)
        if(empty($showEn->seriesName)){
            $showEn->seriesName = $showFr->seriesName;
        }

        # Define status of the show
        if ($showEn->status == 'Continuing'){
            $showStatus = 1;
        } else {
            $showStatus = 0;
        }

        # Create the show
        $showArray = array(
            "thetvdb_id" => $theTvdbId,
            "name" => $showEn->seriesName,
            "name_fr" => $showFr->seriesName,
            "synopsis" => $showEn->overview,
            "synopsis_fr" => $showFr->overview,
            "diffusion_us" => $showEn->firstAired,
            "diffusion_fr" => $this->inputs['diffusion_fr'],
            "format" => $showEn->runtime,
            "taux_erectile" => $this->inputs['taux_erectile'],
            "avis_rentree" => $this->inputs['avis_rentree'],
            "encours" => $showStatus,
            "annee" => date_format(date_create($showEn->firstAired), 'Y'),
            "url" => Str::slug($showEn->seriesName),
            "genres" => $showEn->genre,
            "creators" => $this->inputs['creators'],
            "nationalities" => $this->inputs['nationalities'],
            "channels" => $this->inputs['channels'],
            "poster" => $showEn->poster,
            "banner" => $showEn->banner
        );

        createShow($showArray);

        return true;
    }
}
