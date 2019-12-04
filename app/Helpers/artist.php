<?php

declare(strict_types=1);

use App\Models\Artist;
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
            Log::debug('Artist : ' . $artistBdd->name . 'is created.');
        } else {
            $show->artists()->attach($artistBdd->id, ['profession' => $profession]);
            Log::debug('Artist : ' . $artistBdd->name . 'is linked to ' . $show->name . '.');
        }
    }
}