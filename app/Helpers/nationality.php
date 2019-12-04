<?php

declare(strict_types=1);

use App\Models\Nationality;
use App\Models\Show;
use Illuminate\Support\Str;

function linkAndCreateNationalitiesToShow(Show $show, array $nationalities) {
    foreach ($nationalities as $nationality) {
        $nationality = trim($nationality);
        $nationalityUrl = Str::slug($nationality);

        $nationalityBdd = Nationality::where('nationality_url', $nationalityUrl)->first();
        if (is_null($nationalityBdd)) {
            $nationalityBdd = new Nationality([
                'name' => $nationality,
                'nationality_url' => $nationalityUrl
            ]);
            $show->nationalities()->save($nationalityBdd);
            Log::debug('Nationality : ' . $nationalityBdd->name . 'is created.');
        } else {
            $show->nationalities()->attach($nationalityBdd->id);
            Log::debug('Nationality : ' . $nationalityBdd->name . 'is linked to ' . $show->name . '.');
        }
    }
}