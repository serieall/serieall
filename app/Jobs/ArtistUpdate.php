<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ArtistUpdate
 * @package App\Jobs
 */
class ArtistUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $artist;
    protected $show_id;
    protected $role;
    protected $idLog;

    /**
     * Create a new job instance.
     *
     * @param $artist
     * @param $show_id
     * @param $role
     * @param $idLog
     */
    public function __construct($artist, $show_id, $role, $idLog)
    {
        $this->artist = $artist;
        $this->show_id = $show_id;
        $this->role = $role;
        $this->idLog = $idLog;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->artist->shows()->updateExistingPivot($this->show_id, ['role' => $this->role]);

        $logMessage = 'Mise à jour de l\'artiste ' . $this->artist['name'] . ' de ' . $this->show_id . ' et de son rôle ' . $this->role;
        saveLogMessage($this->idLog, $logMessage);

        endJob($this->idLog);
    }
}
