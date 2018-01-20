<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ArtistsTransformer
 * @package App\Http\Transformers
 */
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