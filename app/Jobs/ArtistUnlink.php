<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ArtistUnlink
 * @package App\Jobs
 */
class ArtistUnlink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $show;
    protected $artistID;
    protected $userID;

    /**
     * Create a new job instance.
     *
     * @param Show $show
     * @param $artistID
     * @param $userID
     * @internal param $artistID
     * @internal param $idLog
     */
    public function __construct(Show $show, $artistID, $userID)
    {
        $this->show = $show;
        $this->artistID = $artistID;
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $idLog = initJob($this->userID, 'Suppression', 'Artist', $this->artistID);

        $this->show->artists()->detach($this->artistID);

        $logMessage = 'Détachement de l\'artiste ' . $this->artistID . ' de la série ' . $this->show['name'];
        saveLogMessage($idLog, $logMessage);

        endJob($idLog);
    }
}
