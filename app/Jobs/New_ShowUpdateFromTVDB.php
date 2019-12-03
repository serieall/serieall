<?php

namespace App\Jobs;

/**
 * Class New_ShowUpdateFromTVDB
 * @package App\Jobs
 */
class New_ShowUpdateFromTVDB extends Job implements ShouldQueue
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

    }
}