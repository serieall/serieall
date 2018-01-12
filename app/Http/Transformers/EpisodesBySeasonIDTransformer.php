<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class EpisodesBySeasonIDTransformer extends TransformerAbstract
{
    /**
     * @param $episode
     * @return array
*/
    public function transform($episode) : array
    {
        return [
            'id' => $episode->id,
            'numero' => $episode->numero,
            'name' => $episode->name,
            'name_fr' => $episode->name_fr,
            'title' => $episode->numero . " - " . $episode->name
        ];
    }
}