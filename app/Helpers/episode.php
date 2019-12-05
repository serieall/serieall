<?php

declare(strict_types=1);

use App\Models\Show;
use GuzzleHttp\Exception\GuzzleException;

function linkAndCreateEpisodesToShow(Show $show) : bool {
    # First, we check the availability of all episodes
    $listEpisodes = getListEpisodes($show, 1);
    if(empty($listEpisodes)) {
        return false;
    }

    # Add episodes and loop over page is necessary
    $listEpisodesNextPage = $listEpisodes->links->next;
    $listEpisodesLastPage = $listEpisodes->links->last;

    $listEpisodesData = $listEpisodes->data;

    if (is_null($listEpisodesNextPage)) {
        Log::debug('Only one page for episodes. Adding episodes...');
        createOrUpdateEpisode($listEpisodesData);
    } else {
        Log::debug('Multiple pages for episodes. Adding page 1/' . $listEpisodesLastPage );
        // TODO: add episodes

        while ($listEpisodesNextPage <= $listEpisodesLastPage) {
            try {
                $listEpisodes = apiTvdbGetEpisodesForShow("fr", $show->thetvdb_id, $listEpisodesNextPage);
                if(empty($listEpisodes)) {
                    return false;
                }

                // TODO : Add episodes
                $listEpisodesNextPage++;
            } catch (GuzzleException | ErrorException $e) {
                Log::error('ShowAddFromTVDB: Episodes not found for language en or fr.');
                return false;
            }
        }

    }
    return true;
}

/**
 * Get the list of episodes
 *
 * @param Show $show
 * @param int $page
 * @return object
 */
function getListEpisodes(Show $show, int $page): object {
    try {
        $listEpisodesEn = apiTvdbGetEpisodesForShow("en", $show->thetvdb_id, $page);
        if($listEpisodesEn->errors->invalidLanguage){
            $listEpisodesFr = apiTvdbGetEpisodesForShow("fr", $show->thetvdb_id, $page);
            if($listEpisodesFr->errors->invalidLanguage){
                Log::error('ShowAddFromTVDB: List of episodes not found either in french or english.');
                return (object) array();
            } else {
                $listEpisodes = $listEpisodesFr;
            }
        } else {
            $listEpisodes = $listEpisodesEn;
        }
        return $listEpisodes;
    } catch (GuzzleException | ErrorException $e) {
        Log::error('ShowAddFromTVDB: Episodes not found for language en or fr.');
        return (object) array();
    }
}

function createOrUpdateEpisode(array $listEpisodes) {
    $episodeNotFound = 0;

    foreach($listEpisodes as $episode){
        # Now, we are getting the informations from the Episode, in english and in french
        try {
            $episodeFr = apiTvdbGetEpisodes('fr', $episode->id)->data;
        } catch (GuzzleException | ErrorException $e) {
            Log::error('ShowAddFromTVDB: Show not found for language fr.');
            $episodeNotFound += 1;
        }
        try {
            $episodeEn = apiTvdbGetShow('en', $episode->id)->data;
        } catch (GuzzleException | ErrorException $e) {
            Log::error('ShowAddFromTVDB: Show not found for language en.');
            $episodeNotFound += 1;
        }

        if($episodeNotFound == 2) {
            # Skipping this episode
            Log::error('ShowAddFromTVDB: Episode not found for language en and fr. Quit.');
            continue;
        }
    }
}