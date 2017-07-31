<?php

namespace App\Jobs;

use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UserDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $userID;

    /**
     * Create a new job instance.
     * @param $id
     * @param $userID
     */
    public function __construct($id, $userID)
    {
        $this->id = $id;
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $userRepository
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob($this->userID, 'Suppression', 'User', $this->id);

        $user = $userRepository->getUserByID($this->id);

        // TODO: Ajouter la suppression des notes etc...
        $logMessage = '>>> Suppression de l\'utilisateur : ' . $user->username ;
        saveLogMessage($idLog, $logMessage);

        $user->delete();

        endJob($idLog);
    }
}
