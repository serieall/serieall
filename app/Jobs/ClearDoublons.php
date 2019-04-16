<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Artist;
use App\Models\Temp;
use App\Models\Season;
use App\Models\Episode;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client;

use \Illuminate\Support\Str;

/**
 * Class ShowUpdateFromTVDB
 * @package App\Jobs
 */
class ClearDoublons extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * ShowUpdateFromTVDB constructor.
     */
    public function __construct()
    {
    }





    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob(null, 'Clear Doublons', 'Show', 0 );

        /*
        |--------------------------------------------------------------------------
        | End Log
        |--------------------------------------------------------------------------
        */
        endJob($idLog);
    }
}