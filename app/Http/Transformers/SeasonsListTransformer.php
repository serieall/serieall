<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class SeasonsListTransformer
 * @package App\Http\Transformers
 */
class SeasonsListTransformer extends TransformerAbstract
{
    /**
     * @param $category
     * @return array
     */
    public function transform($category) : array
    {
        return [
            'id' => $category->id,
            'name' => $category->name];
    }
}