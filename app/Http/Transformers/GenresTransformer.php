<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class GenresTransformer extends TransformerAbstract
{
    /**
     * @param $genre
     * @return array
     */
    public function transform($genre) : array
    {
        return [
            'name' => $genre->name,
        ];
    }
}