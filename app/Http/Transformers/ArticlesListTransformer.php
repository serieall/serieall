<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ShowsListTransformer
 * @package App\Http\Transformers
 */
class ArticlesListTransformer extends TransformerAbstract
{
    /**
     * @param $show
     * @return array
     */
    public function transform($article) : array
    {
        return [
            'id' => $article->id,
            'name' => $article->name
        ];
    }
}