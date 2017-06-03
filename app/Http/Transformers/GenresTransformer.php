<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class GenresTransformer extends TransformerAbstract
{
    public function transform($genre) : array
    {
        return [
            'name' => $genre->name,
        ];
    }
}