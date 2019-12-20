<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Log;

/**
 * Class ShowUpdateFromTVDB
 * @package App\Jobs
 */
class OneShowUpdateFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $id;

    /**
     * ShowUpdateFromTVDB constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle() {
        Log::debug('OneShowUpdateFromTVDB: Start a job with : ' . json_encode($this->id));

        $inputs = array(
            'thetvdb_id' => $this->id
        );

        createOrUpdateShow($inputs);
        Log::debug('OneShowUpdateFromTVDB: Enf of job with : ' . json_encode($this->id));
    }
}