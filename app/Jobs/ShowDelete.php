<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        // Initilisation du repository
        $this->showRepository = $showRepository;
        
        $idLog = initJob($this->userID, 'Suppression', 'Show', $this->id);
        
        // On cherche la série
        $show = $this->showRepository->getByID($this->id);

        // On détache tous les artistes, chaines, nationalités et les genres
        $logMessage = '> Détachement des artistes';
        saveLogMessage($idLog, $logMessage);
        $show->artists()->detach();

        $logMessage = '> Détachement des chaines';
        saveLogMessage($idLog, $logMessage);
        $show->channels()->detach();

        $logMessage = '> Détachement des nationalités';
        saveLogMessage($idLog, $logMessage);
        $show->nationalities()->detach();

        $logMessage = '> Détachement des genres';
        saveLogMessage($idLog, $logMessage);
        $show->genres()->detach();

        // On récupère les saisons
        $seasons = $show->seasons()->get();

        // Pour chaque saison
        foreach($seasons as $season){
            $logMessage = '> SAISON ' . $season->name;
            saveLogMessage($idLog, $logMessage);

            // On récupère les épisodes
            $episodes = $season->episodes()->get();

            // Pour chaque épisode
            foreach($episodes as $episode){
                $logMessage = '>> EPISODE ' . $episode->numero;
                saveLogMessage($idLog, $logMessage);

                // On détache les artistes
                $logMessage = '>>> Détachement des artistes';
                saveLogMessage($idLog, $logMessage);
                $episode->artists()->detach();

                // On détache les avis
                $episode->comments()->delete();

                // On détache les notes
                $episode->users()->detach();

                // On le supprime
                $logMessage = '>>> Suppression de l\'épisode';
                saveLogMessage($idLog, $logMessage);
                $episode->delete();
            }
            // On supprime la saison
            $logMessage = '>> Suppression de la saison';
            saveLogMessage($idLog, $logMessage);
            $season->delete();
        }

        // On supprime la série
        $logMessage = '> Suppression de la série';
        saveLogMessage($idLog, $logMessage);
        $show->delete();
        
        endJob($idLog);
    }
}
