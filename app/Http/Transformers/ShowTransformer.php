<?php

namespace App\Http\Transformers;

use App\Models\Show;
use League\Fractal\TransformerAbstract;

class ShowTransformer extends TransformerAbstract
{
    public function transform($show) : array
    {
        return [
            'name' => $show->name,
            'url' => "/serie/" . $show->show_url,
        ];
    }
}