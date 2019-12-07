<?php

declare(strict_types=1);

use App\Models\Season;
use App\Models\Show;
use GuzzleHttp\Exception\GuzzleException;

function linkAndCreateSeasonsToShow(Show $show) {
    try {
        $episodesSummary = apiTvdbGetEpisodesSummary($show->thetvdb_id)->data;
    } catch (GuzzleException | ErrorException $e) {
        Log::error('Season: Seasons not found.');
        return false;
    }

    foreach($episodesSummary->airedSeasons as $season) {
        $season = (int) $season;
        if($season != 0){
            try {
                $episode = apiTvdbGetFirstEpisodeForSeason($show->thetvdb_id, $season)->data;
            } catch (GuzzleException | ErrorException $e) {
                Log::error('Season: First episode not found for season ' . $season . '. Continue...');
                continue;
            }

            $seasonInfo = array(
                'name' => $episode[0]->airedSeason,
                'thetvdb_id' => $episode[0]->airedSeasonID
            );

            createOrUpdateSeason($show, $seasonInfo);
        }
    }
    return true;
}

function createOrUpdateSeason(Show $show, array $season) {
    # We check if the season exists, and then create it or update it.
    $seasonBdd = Season::where('thetvdb_id', $season['thetvdb_id'])->first();
    if (is_null($seasonBdd)) {
        $seasonBdd = new Season([
            'name' => $season['name'],
            'thetvdb_id' => $season['thetvdb_id']
        ]);

        $seasonBdd->show()->associate($show);
        $seasonBdd->save();
    } else {
        $seasonBdd->name = $season['name'];

        $seasonBdd->show()->associate($show);
        $seasonBdd->save();
    }
}