<?php


namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Récupère l'utilisateur en fonction de son pseudo
     *
     * @param $username
     * @return User
     */
    public function getUserByUsername($username){
        return $this->user->where('username', $username)->firstOrFail();
    }
}