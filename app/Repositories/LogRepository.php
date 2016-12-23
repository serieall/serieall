<?php


namespace App\Repositories;

use App\Models\Log;
use App\Models\List_log;
use Carbon\Carbon;

/**
 * Class AdminShowRepository
 * @package App\Repositories\Admin
 */
class LogRepository
{
    /**
    * @var Log
    */
    protected $log;
    protected $list_log;

    /**
     * SeasonRepository constructor.
     * @param Log $log
     * @param List_log $list_log
     */
    public function __construct(Log $log, List_log $list_log)
    {
        $this->log = $log;
        $this->list_log = $list_log;
    }

    public function getDistinctLogs(){
        $dateNow = Carbon::now();
        $dateTwoDaysAGo = $dateNow->subDay(2);
        return $this->list_log->with('user')->select('id', 'job', 'object', 'object_id', 'user_id')->where('created_at', '>=', $dateTwoDaysAGo)->distinct()->get();
    }

    /**
     * @param $id
     */
    public function getLogsByID($id){
        return $this->list_log->with('logs','user')->find($id);
    }
}
