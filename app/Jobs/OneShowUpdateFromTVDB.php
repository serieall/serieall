<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Class ShowUpdateFromTVDB.
 */
class OneShowUpdateFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue;
    use SerializesModels;

    protected $id;

    /**
     * ShowUpdateFromTVDB constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        Log::debug('OneShowUpdateFromTVDB: Start a job with : '.json_encode($this->id));

        $inputs = [
            'thetvdb_id' => $this->id,
        ];

        createOrUpdateShow($inputs);
        Log::debug('OneShowUpdateFromTVDB: Enf of job with : '.json_encode($this->id));
    }
}
