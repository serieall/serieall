<?php
/**
 * Created by PhpStorm.
 * User: Youkoulayley
 * Date: 20/10/2016
 * Time: 11:46
 */
use App\Models\Log;

function saveLogMessage($logName, $logMessage){
    $log = new Log();
    $log->name = $logName;
    $log->message = $logMessage;
    $log->save();

    return true;
}