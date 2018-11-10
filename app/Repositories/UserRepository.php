<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Show_user;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 * @package App\Repositories
 */
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
        return $this->user::with(['articles' => function ($q) {
            $q->orderBy('published_at', 'desc')->paginate(2);
        }])->where('user_url', $user_url)->firstOrFail();
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

    /**
     * Get planning for user
     *
     * @param $user_id
     * @param $state
     * @return mixed
     */
    public function getEpisodePlanning($user_id, $state) {
        return $this->user->join('show_user', 'users.id', '=', 'show_user.user_id')
            ->join('shows', 'show_user.show_id', '=', 'shows.id')
            ->join('seasons', 'shows.id', '=', 'seasons.show_id')
            ->join('episodes', 'seasons.id', '=', 'episodes.season_id')
            ->where('users.id', '=', $user_id)
            ->where('show_user.state', '=', $state)
            ->whereBetween('episodes.diffusion_us', [
                Carbon::now()->subMonth(1),
                Carbon::now()->addMonth(1)])
            ->select(DB::raw('shows.name as show_name, seasons.name as season_name, episodes.name as episode_name, episodes.id, episodes.numero, episodes.diffusion_us, shows.show_url'))
            ->get();
    }
}