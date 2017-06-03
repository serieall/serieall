<?php
namespace App\Repositories;


use Carbon\Carbon;
use Illuminate\Database\Connection;

class ActivationRepository
{

    protected $db;
    protected $table = 'user_activations';

    /**
     * ActivationRepository constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * On génére un token en fonction de la clé de l'application
     *
     * @return string
     */
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * On crée l'activation en fonction de l'utilisateur
     *
     * @param $user
     * @return string
     */
    public function createActivation($user)
    {
        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);

    }

    /**
     * On regénère le token pour un utilisateur
     *
     * @param $user
     * @return string
     */
    private function regenerateToken($user)
    {
        $token = $this->getToken();
        $this->db->table($this->table)->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    /**
     * On crée un token pour un utilisateur
     *
     * @param $user
     * @return string
     */
    private function createToken($user)
    {
        $token = $this->getToken();
        $this->db->table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    /**
     * On récupère l'activation d'un utilisateur
     *
     * @param $user
     * @return mixed
     */
    public function getActivation($user)
    {
        return $this->db->table($this->table)->where('user_id', $user->id)->first();
    }

    /**
     * On récupère une activation en fonction du token
     * @param $token
     * @return mixed
     */
    public function getActivationByToken($token)
    {
        return $this->db->table($this->table)->where('token', $token)->first();
    }

    /**
     * On supprime une activation
     *
     * @param $token
     */
    public function deleteActivation($token)
    {
        $this->db->table($this->table)->where('token', $token)->delete();
    }

}