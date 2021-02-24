<?php

namespace App\Jobs;

use App\Repositories\LogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class FlushLogs1Week.
 */
class FlushLogs1Week implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Exception
     * @throws \Exception
     */
    public function handle(LogRepository $logRepository)
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob(null, 'Suppression des logs', 'Logs', 0);

        /*
        | Récupération des logs
        */
        $logs = $logRepository->getLogsSup1Week();

        /*
        | Suppression des logs
        */
        foreach ($logs as $log) {
            $logMessage = '> '.$log->job;
            saveLogMessage($idLog, $logMessage);

            $messages = $logRepository->getLogByID($log->id);
            $logMessage = 'Suppression des messages';
            saveLogMessage($idLog, $logMessage);

            foreach ($messages->logs as $message) {
                $message->delete();
            }

            $logMessage = 'Suppression du job';
            saveLogMessage($idLog, $logMessage);
            $log->delete();
        }

        endJob($idLog);
    }
}
