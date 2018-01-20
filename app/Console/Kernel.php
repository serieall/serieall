<?php
declare(strict_types=1);

namespace App\Console;

use App\Jobs\FlushLogs1Week;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ShowUpdateFromTVDB;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            dispatch(new ShowUpdateFromTVDB());
        })->daily();

        $schedule->call(function() {
            dispatch(new FlushLogs1Week());
        })->daily();
    }
}
