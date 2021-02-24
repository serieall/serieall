<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ShowsListTransformer.
 */
class ArticlesListTransformer extends TransformerAbstract
{
    /**
     * @param $show
     */
    public function transform($article): array
    {
        return [
            'id' => $article->id,
            'name' => $article->name,
        ];
    }
}
