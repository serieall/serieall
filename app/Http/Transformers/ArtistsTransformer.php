<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ArtistsTransformer.
 */
class ArtistsTransformer extends TransformerAbstract
{
    /**
     * @param $artist
     */
    public function transform($artist): array
    {
        return [
            'name' => $artist->name, ];
    }
}
