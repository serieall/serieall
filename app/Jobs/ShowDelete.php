<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\List_log;

use App\Repositories\ShowRepository;

class ShowDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $userID;
    private $showRepository;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $userID
     * @internal param ShowRepository $showRepository
     */
    public function __construct($id, $userID)
    {
        $this->id = $id;
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     *
     * @param ShowRepository $showRepository
     * @return void
     */
    public function handle(ShowRepository $showRepository)
    {
        $this->showRepository = $showRepository;

        # Définition du nom du job
        $list_log = new List_log();
        $list_log->job = 'Suppression';
        $list_log->object = 'Show';
        $list_log->object_id = $this->id;
        $list_log->user_id = $this->userID;
        $list_log->save();

        $logID = $list_log->id;

        $logMessage = '>>>>>>>>>> Lancement de la suppression <<<<<<<<<<';
        saveLogMessage($logID, $logMessage);

        // On cherche la série
        $show = $this->showRepository->getByID($this->id);

        // On détache tous les artistes, chaines, nationalités et les genres
        $logMessage = '> Détachement des artistes';
        saveLogMessage($logID, $logMessage);
        $show->artists()->detach();

        $logMessage = '> Détachement des chaines';
        saveLogMessage($logID, $logMessage);
        $show->channels()->detach();

        $logMessage = '> Détachement des nationalités';
        saveLogMessage($logID, $logMessage);
        $show->nationalities()->detach();

        $logMessage = '> Détachement des genres';
        saveLogMessage($logID, $logMessage);
        $show->genres()->detach();

        // On récupère les saisons
        $seasons = $show->seasons()->get();

        // Pour chaque saison
        foreach($seasons as $season){
            $logMessage = '> SAISON ' . $season->name;
            saveLogMessage($logID, $logMessage);

            // On récupère les épisodes
            $episodes = $season->episodes()->get();

            // Pour chaque épisode
            foreach($episodes as $episode){
                $logMessage = '>> EPISODE ' . $episode->numero;
                saveLogMessage($logID, $logMessage);

                // On détache les artistes
                $logMessage = '>>> Détachement des artistes';
                saveLogMessage($logID, $logMessage);
                $episode->artists()->detach();

                // On le supprime
                $logMessage = '>>> Suppression de l\'épisode';
                saveLogMessage($logID, $logMessage);
                $episode->delete();
            }
            // On supprime la saison
            $logMessage = '>> Suppression de la saison';
            saveLogMessage($logID, $logMessage);
            $season->delete();
        }

        // On supprime la série
        $logMessage = '> Suppression de la série';
        saveLogMessage($logID, $logMessage);
        $show->delete();
    }
}
