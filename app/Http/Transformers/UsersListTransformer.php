<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

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