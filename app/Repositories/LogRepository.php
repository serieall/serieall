<?php


namespace App\Repositories;

use App\Models\Log;
use App\Models\List_log;
use Carbon\Carbon;

/**
 * Class ShowRepository
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

    public function getTenDistinctLogs(){
        return $this->list_log->with('user')->select('id', 'job', 'object', 'object_id', 'user_id', 'created_at')->limit(10)->orderBy('id', 'desc')->distinct()->get();
    }

    public function getAllDistinctLogs(){
        return $this->list_log->with('user')->select('id', 'job', 'object', 'object_id', 'user_id', 'created_at')->orderBy('id', 'desc')->distinct()->get();
    }

    /**
     * @param $id
     * @return LogRepository
     */
    public function getLogByID($id){
        return $this->list_log->with('logs','user')->find($id);
    }
}
