<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class EpisodesBySeasonIDTransformer
 * @package App\Http\Transformers
 */
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
            'title' => $episode->numero . ' - ' . $episode->name
        ];
    }
}