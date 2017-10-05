<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class EpisodesBySeasonIDTransformer extends TransformerAbstract
{
    /**
     * @param $genre
     * @return array
     */
    public function transform($episode) : array
    {
        return [
            'numero' => $episode->numero,
            'name' => $episode->name,
            'name_fr' => $episode->name_fr,
        ];
    }
}