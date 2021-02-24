<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class GenresTransformer.
 */
class GenresTransformer extends TransformerAbstract
{
    /**
     * @param $genre
     */
    public function transform($genre): array
    {
        return [
            'name' => $genre->name,
        ];
    }
}
