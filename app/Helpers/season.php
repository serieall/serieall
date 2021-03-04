<?php

declare(strict_types=1);

use App\Models\Season;
use App\Models\Show;
use GuzzleHttp\Exception\GuzzleException;

function linkAndCreateSeasonsToShow(Show $show)
{
    try {
        $episodesSummary = apiTvdbGetEpisodesSummary($show->tmdb_id)->data;
    } catch (GuzzleException | ErrorException $e) {
        Log::error('Season: Seasons not found.');

        return false;
    }

    foreach ($episodesSummary->airedSeasons as $season) {
        $season = (int) $season;
        if (0 != $season) {
            try {
                $episode = apiTvdbGetFirstEpisodeForSeason($show->tmdb_id, $season)->data;
            } catch (GuzzleException | ErrorException $e) {
                Log::error('Season: First episode not found for season '.$season.'. Continue...');
                continue;
            }

            $seasonInfo = [
                'name' => $episode[0]->airedSeason,
                'tmdb_id' => $episode[0]->airedSeasonID,
            ];

            createOrUpdateSeason($show, $seasonInfo);
        }
    }

    return true;
}

function createOrUpdateSeason(Show $show, array $season)
{
    // We check if the season exists, and then create it or update it.
    $seasonBdd = Season::where('tmdb_id', $season['tmdb_id'])->first();
    if (is_null($seasonBdd)) {
        $seasonBdd = new Season([
            'name' => $season['name'],
            'tmdb_id' => $season['tmdb_id'],
        ]);

        $seasonBdd->show()->associate($show);
        $seasonBdd->save();
    } else {
        $seasonBdd->name = $season['name'];

        $seasonBdd->show()->associate($show);
        $seasonBdd->save();
    }
}
