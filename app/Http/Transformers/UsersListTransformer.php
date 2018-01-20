<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class UsersListTransformer
 * @package App\Http\Transformers
 */
class UsersListTransformer extends TransformerAbstract
{
    /**
     * @param $user
     * @return array
     */
    public function transform($user) : array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
        ];
    }
}