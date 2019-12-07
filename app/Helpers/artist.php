<?php

declare(strict_types=1);

use App\Models\Artist;
use App\Models\Episode;
use App\Models\Show;
use Illuminate\Support\Str;

function linkAndCreateArtistsToShow(Show $show, array $artists, string $profession) {
    foreach ($artists as $artist) {
        $artist = trim($artist);
        $artistUrl = Str::slug($artist);

        # On vérifie si le genre existe déjà en base
        $artistBdd = Artist::where('artist_url', $artistUrl)->first();

        # Si il n'existe pas
        if (is_null($artistBdd)) {
            $artistBdd = new Artist([
                'name' => $artist,
                'artist_url' => $artistUrl
            ]);
            $show->artists()->save($artistBdd, ['profession' => $profession]);
            Log::debug('Artist : ' . $artistBdd->name . ' is created.');
        } else {
            $show->artists()->attach($artistBdd->id, ['profession' => $profession]);
            Log::debug('Artist : ' . $artistBdd->name . ' is linked to ' . $show->name . '.');
        }
    }
}

function linkAndCreateArtistsToEpisode(Episode $episode, array $artists, string $profession) {
    foreach ($artists as $artist) {
        $artist = trim($artist);
        $artistUrl = Str::slug($artist);

        # On vérifie si le genre existe déjà en base
        $artistBdd = Artist::where('artist_url', $artistUrl)->first();

        # Si il n'existe pas
        if (is_null($artistBdd)) {
            $artistBdd = new Artist([
                'name' => $artist,
                'artist_url' => $artistUrl
            ]);
            $episode->artists()->save($artistBdd, ['profession' => $profession]);
            Log::debug('Artist : ' . $artistBdd->name . ' is created.');
        } else {
            $episode->artists()->attach($artistBdd->id, ['profession' => $profession]);
            Log::debug('Artist : ' . $artistBdd->name . ' is linked to episode ' . $episode->numero . '.');
        }
    }
}

function linkAndCreateActorsToShow(Show $show, array $actors) {
    $public = public_path();

    foreach ($actors as $actor) {
        $actorName = trim($actor->name);
        $actorRole = trim($actor->role);
        $actorUrl = Str::slug($actorName);

        # On vérifie si le genre existe déjà en base
        $actorBdd = Artist::where('artist_url', $actorUrl)->first();

        # Si il n'existe pas
        if (is_null($actorBdd)) {
            $actorBdd = new Artist([
                'name' => $actorName,
                'artist_url' => $actorUrl
            ]);
            $show->artists()->save($actorBdd, ['profession' => 'actor', 'role' => $actorRole]);
            Log::debug('Artist : ' . $actorBdd->name . ' is created.');
        } else {
            $show->artists()->attach($actorBdd->id, ['profession' => 'actor', 'role' => $actorRole]);
            Log::debug('Artist : ' . $actorBdd->name . ' is linked to ' . $show->name . '.');
        }

        /* Récupération de la photo de l'acteur */
        $actorImage = config('thetvdb.imageUrl') . $actor->image;;
        $actorImageHeaders = get_headers($actorImage);
        if(!$actorImageHeaders || $actorImageHeaders[0] == 'HTTP/1.1 404 Not Found') {
            Log::Error('Artist : ' . $actorBdd->name . ' doesn\'t have image.');
        }
        else {
            copy($actorImage, $public . '/images/actors/' . $actorBdd->artist_url . '.jpg');
            Log::debug('Artist : Image for ' . $actorBdd->name . ' was downloaded.');
        }
    }
}