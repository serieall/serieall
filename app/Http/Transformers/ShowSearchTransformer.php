<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ShowSearchTransformer.
 */
class ShowSearchTransformer extends TransformerAbstract
{
    /**
     * @param $show
     */
    public function transform($show): array
    {
        return [
            'id' => $show->id,
            'url' => '/serie/'.$show->show_url,
            'name' => $show->name, ];
    }
}
