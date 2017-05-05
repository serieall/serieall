<?php

namespace App\Http\Transformers;

use App\Models\Show;
use League\Fractal\TransformerAbstract;

class ShowTransformer extends TransformerAbstract
{
    public function transform(Show $show) : array
    {
        return [
            'name' => $show->name,
            'name_lower' => $show->name_lower,
            'url' => "/serie/" . $show->show_url,
        ];
    }
}