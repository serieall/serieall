<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CategoriesListTransformer extends TransformerAbstract
{
    /**
     * @param $category
     * @return array
     */
    public function transform($category) : array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}