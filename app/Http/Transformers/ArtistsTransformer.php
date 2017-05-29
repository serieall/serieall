<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ArtistsTransformer extends TransformerAbstract
{
    public function transform($artist) : array
    {
        return [
            'name' => $artist->name,
        ];
    }
}