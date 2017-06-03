<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ChannelsTransformer extends TransformerAbstract
{
    public function transform($channel) : array
    {
        return [
            'name' => $channel->name,
        ];
    }
}