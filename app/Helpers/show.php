<?php

declare(strict_types=1);

use App\Models\Show;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

function createShow($show): Show {
    # Create the show
    $showBdd = new Show([
        "thetvdb_id" => $show['thetvdb_id'],
        "name" => $show['name'],
        "name_fr" => $show['name_fr'],
        "synopsis" => $show['synopsis'],
        "synopsis_fr" => $show['synopsis_fr'],
        "diffusion_us" => $show['diffusion_us'],
        "diffusion_fr" => $show['diffusion_fr'],
        "format" => $show['format'],
        "taux_erectile" => $show['taux_erectile'],
        "avis_rentree" => $show['avis_rentree'],
        "encours" => $show['encours'],
        "annee" => $show['annee'],
        "show_url" => $show['url'],
    ]);

    $showBdd->save();
    Log::debug('Show : ' . $showBdd->name . 'is created.');

    # Get the images for the show
    $showPoster = config('thetvdb.imageUrl') . $show['poster'];
    $showBanner = config('thetvdb.imageUrl') . $show['banner'];

    publishImage($showPoster, Str::slug($show['name']), "poster", "middle", true);
    publishImage($showBanner, Str::slug($show['name']), "banner", "middle", true);

    if ($show['genres'] && !empty($show['genres'])) {
        Log::debug('Show : Link and create all genres for ' . $showBdd->name . '.');
        linkAndCreateGenresToShow($showBdd, $show['genres']);
    }

    if($show['creators'] && !empty($show['creators'])) {
        Log::debug('Show : Link and create all creators for ' . $showBdd->name . '.');
        $show['creators'] = explode(',', $show['creators']);
        linkAndCreateArtistsToShow($showBdd, $show['creators'], "creator");
    }

    if($show['nationalities'] && !empty($show['nationalities'])) {
        Log::debug('Show : Link and create all nationalities for ' . $showBdd->name . '.');
        $show['nationalities'] = explode(',', $show['nationalities']);
        linkAndCreateNationalitiesToShow($showBdd, $show['nationalities']);
    }

    if($show['channels'] && !empty($show['channels'])) {
        Log::debug('Show : Link and create all channels for ' . $showBdd->name . '.');
        $show['channels'] = explode(',', $show['channels']);
        linkAndCreateChannelsToShow($showBdd, $show['channels']);
    }

    # Now, we are getting the informations from the actors
    try {
        $actors = apiTvdbGetActorsForShow($showBdd->thetvdb_id)->data;
        linkAndCreateActorsToShow($show, $actors);
    } catch (GuzzleException | ErrorException $e) {
        Log::error('ShowAddFromTVDB: No actors for the show : ' . $show->name . '.');
    }

    try {
        linkAndCreateSeasonsToShow($showBdd);
    } catch (GuzzleException | ErrorException $e) {
        Log::error('ShowAddFromTVDB: No seasons for the show : ' . $show->name . '.');
    }

    try {
        linkAndCreateEpisodesToShow($showBdd);
    } catch (GuzzleException | ErrorException $e) {
        Log::error('ShowAddFromTVDB: No episodes for the show : ' . $show->name . '.');
    }


    return $showBdd;
}