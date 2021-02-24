<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ChannelsTransformer.
 */
class ChannelsTransformer extends TransformerAbstract
{
    /**
     * @param $channel
     */
    public function transform($channel): array
    {
        return [
            'name' => $channel->name, ];
    }
}
