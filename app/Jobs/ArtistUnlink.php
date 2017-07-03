<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ArtistUnlink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $show;
    protected $artist_id;
    protected $idLog;

    /**
     * Create a new job instance.
     *
     * @param $show
     * @param $artist_id
     * @param $idLog
     */
    public function __construct($show, $artist_id, $idLog)
    {
        $this->show = $show;
        $this->artist_id = $artist_id;
        $this->idLog = $idLog;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->show->artists()->detach($this->artist_id);

        $logMessage = 'Détachement de l\'artiste ' . $this->artist_id . ' de la série ' . $this->show['name'];
        saveLogMessage($this->idLog, $logMessage);

        endJob($this->idLog);
    }
}
