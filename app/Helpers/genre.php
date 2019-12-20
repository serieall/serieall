<?php

declare(strict_types=1);

use App\Models\Genre;
use App\Models\Show;
use Illuminate\Support\Str;

function linkAndCreateGenresToShow(Show $show, array $genres) {
    foreach ($genres as $genre) {
        $genre = trim($genre);
        $genreUrl = Str::slug($genre);

        # Check if the genre exists on BDD
        $genreBdd = Genre::where('genre_url', $genreUrl)->first();
        if (is_null($genreBdd)) {
            $genreBdd = new Genre([
                'name' => $genre,
                'genre_url' => $genreUrl
            ]);

            $show->genres()->save($genreBdd);
            Log::debug('Genre : ' . $genreBdd->name . ' is created.');
        } else {
            $genreLink = $genreBdd->shows()->where('shows.thetvdb_id', $show->thetvdb_id)->first();
            if (empty($genreLink)) {
                $show->genres()->attach($genreBdd->id);
                Log::debug('Genre : ' . $genreBdd->name . ' is linked to ' . $show->name . '.');
            } else {
                Log::debug('Genre : ' . $genreBdd->name . ' is already linked to ' . $show->name . '.');
            }

        }
    }
}