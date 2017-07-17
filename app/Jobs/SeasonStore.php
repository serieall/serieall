<?php

namespace App\Jobs;

use App\Repositories\ShowRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Season;

class SeasonStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @param $inputs
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @param ShowRepository $showRepository
     * @return void
     */
    public function handle(ShowRepository $showRepository)
    {
        $idLog = initJob($this->inputs['user_id'], 'Ajout Manuel', 'Season', mt_rand());
        $show = $showRepository->getByID($this->inputs['show_id']);

        foreach($this->inputs['seasons'] as $season)
        {
            $message = 'Ajout de la saison ' . $season['name'] . '|' . $show->name;
            saveLogMessage($idLog, $message);

            $seasonNew = new Season();

            $seasonNew->name = $season['name'];
            $message = 'Numéro : ' . $season['name'];
            saveLogMessage($idLog, $message);

            $seasonNew->ba = $season['ba'];
            $message = 'Bande Annonce : ' . $season['ba'];
            saveLogMessage($idLog, $message);

            $seasonNew->show()->associate($show);
            $seasonNew->save();
        }

        endJob($idLog);
    }
}
