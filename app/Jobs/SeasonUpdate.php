<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\SeasonRepository;

class SeasonUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inputs;
    protected $seasonRepository;

    /**
     * Create a new job instance.
     *
     * @param $inputs
     * @internal param SeasonRepository $seasonRepository
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @param SeasonRepository $seasonRepository
     * @return void
     */
    public function handle(SeasonRepository $seasonRepository)
    {
        $idLog = initJob($this->inputs['user_id'], 'Edition', 'Season', $this->inputs['id']);

        $season = $seasonRepository->getSeasonByID($this->inputs['id']);

        $message = 'Mise à jour de la saison ' . $this->inputs['name'] . '|' . $this->inputs['id'];
        saveLogMessage($idLog, $message);

        $season->name = $this->inputs['name'];
        $message = 'Numéro . ' . $this->inputs['name'];
        saveLogMessage($idLog, $message);

        $season->ba = $this->inputs['ba'];
        $message = 'Bande Annonce . ' . $this->inputs['ba'];
        saveLogMessage($idLog, $message);

        $season->save();

        endJob($idLog);
    }
}
