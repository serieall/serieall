<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class GenresTransformer
 * @package App\Http\Transformers
 */
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