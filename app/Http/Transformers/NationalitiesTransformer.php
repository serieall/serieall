<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class NationalitiesTransformer extends TransformerAbstract
{
    public function transform($nationality) : array
    {
        return [
            'name' => $nationality->name,
        ];
    }
}