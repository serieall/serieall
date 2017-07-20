<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ArtistsTransformer extends TransformerAbstract
{
    /**
     * @param $artist
     * @return array
     */
    public function transform($artist) : array
    {
        return [
            'name' => $artist->name,
        ];
    }
}