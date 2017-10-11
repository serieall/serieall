<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ShowsListTransformer extends TransformerAbstract
{
    /**
     * @param $show
     * @return array
     */
    public function transform($show) : array
    {
        return [
            'id' => $show->id,
            'url' => "/serie/" . $show->show_url,
            'name' => $show->name,
            'genres' => $show->genres,
        ];
    }
}