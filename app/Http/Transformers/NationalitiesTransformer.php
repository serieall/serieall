<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class NationalitiesTransformer
 * @package App\Http\Transformers
 */
class NationalitiesTransformer extends TransformerAbstract
{
    /**
     * @param $nationality
     * @return array
     */
    public function transform($nationality) : array
    {
        return [
            'name' => $nationality->name];
    }
}