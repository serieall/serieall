<?php

declare(strict_types=1);

use App\Models\Nationality;
use App\Models\Show;
use Illuminate\Support\Str;

function linkAndCreateNationalitiesToShow(Show $show, array $nationalities)
{
    foreach ($nationalities as $nationality) {
        $nationality = trim($nationality);
        $nationalityUrl = Str::slug($nationality);

        $nationalityBdd = Nationality::where('nationality_url', $nationalityUrl)->first();
        if (is_null($nationalityBdd)) {
            $nationalityBdd = new Nationality([
                'name' => $nationality,
                'nationality_url' => $nationalityUrl,
            ]);
            $show->nationalities()->save($nationalityBdd);
            Log::debug('Nationality : '.$nationalityBdd->name.'is created.');
        } else {
            $nationalityLink = $nationalityBdd->shows()->where('shows.thetvdb_id', $show->thetvdb_id)->first();
            if (empty($nationalityLink)) {
                $show->nationalities()->attach($nationalityBdd->id);
                Log::debug('Nationality : '.$nationalityBdd->name.'is linked to '.$show->name.'.');
            } else {
                Log::debug('Nationality : '.$nationalityBdd->name.'is already linked to '.$show->name.'.');
            }
        }
    }
}
