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
        'url' => $show->show_url,
    ];
    }
}