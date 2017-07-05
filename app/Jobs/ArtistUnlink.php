<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Auth;

class ArtistUnlink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $show;
    protected $artist_id;

    /**
     * Create a new job instance.
     *
     * @param $show
     * @param $artist_id
     * @param $idLog
     */
    public function __construct($show, $artist_id)
    {
        $this->show = $show;
        $this->artist_id = $artist_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $idLog = initJob(Auth::user()->id, 'Delete', 'Artist', $this->artist_id);

        $this->show->artists()->detach($this->artist_id);

        $logMessage = 'Détachement de l\'artiste ' . $this->artist_id . ' de la série ' . $this->show['name'];
        saveLogMessage($idLog, $logMessage);

        endJob($idLog);
    }
}
