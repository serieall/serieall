<?php

namespace App\Jobs;

use App\Repositories\LogRepository;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FlushLogs1Week implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param LogRepository $logRepository
     * @return void
     */
    public function handle(LogRepository $logRepository)
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob(null, 'Suppression des logs', 'Logs', 0 );

        /*
        | Récupération des logs
        */
        $logs = $logRepository->getLogsSup1Week();

        /*
        | Suppression des logs
        */
        foreach($logs as $log)
        {
            $logMessage = '> ' . $log->job;
            saveLogMessage($idLog, $logMessage);

            $messages = $logRepository->getLogByID($log->id);
            $logMessage = 'Suppression des messages';
            saveLogMessage($idLog, $logMessage);

            foreach($messages->logs as $message)
            {
                $message->delete();
            }

            $logMessage = 'Suppression du job';
            saveLogMessage($idLog, $logMessage);
            $log->delete();
        }

        endJob($idLog);
    }
}
