<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class NationalitiesTransformer.
 */
class NationalitiesTransformer extends TransformerAbstract
{
    /**
     * @param $nationality
     */
    public function transform($nationality): array
    {
        return [
            'name' => $nationality->name, ];
    }
}
