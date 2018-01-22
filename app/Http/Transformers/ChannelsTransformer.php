<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ChannelsTransformer
 * @package App\Http\Transformers
 */
class ChannelsTransformer extends TransformerAbstract
{
    /**
     * @param $channel
     * @return array
     */
    public function transform($channel) : array
    {
        return [
            'name' => $channel->name];
    }
}