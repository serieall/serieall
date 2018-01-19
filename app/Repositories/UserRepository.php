<?php


namespace App\Repositories;

use App\Models\User;

use Illuminate\Support\Facades\DB;

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
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getUserByUsername($username){
        return $this->user::where('username', $username)->firstOrFail();
    }

    /**
     * Récupère l'utilisateur en fonction de son URL
     *
     * @param $user_url
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getUserByURL($user_url){
        return $this->user::where('user_url', $user_url)->firstOrFail();
    }

    /**
     * Récupère tous les utilisateurs
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllUsers()
    {
        return DB::table('users')
            ->orderBy('username', 'asc')
            ->get();
    }

    /**
     * Récupère un utilisateur via son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getUserByID($id)
    {
        return $this->user::findOrFail($id);
    }
}