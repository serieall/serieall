<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class CategoriesListTransformer.
 */
class CategoriesListTransformer extends TransformerAbstract
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
