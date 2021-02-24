<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class SeasonsListTransformer.
 */
class SeasonsListTransformer extends TransformerAbstract
{
    /**
     * @param $category
     */
    public function transform($category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name, ];
    }
}
