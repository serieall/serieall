<?php

use App\Models\List_log;

use App\Models\Log;

/**
 * Init a new job's log
 *
 * @param $user_id
 * @param $type
 * @param $model
 * @param $model_id
 * @return int
 */
function initJob($user_id, $type, $model, $model_id)
{
    # Initialize Log
    $list_log = new List_log();

    # Fill fields
    $list_log->job = $type;
    $list_log->object = $model;
    $list_log->object_id = $model_id;
    $list_log->user_id = $user_id;

    # Save object
    $list_log->save();

    # Get ID
    $list_log_id = $list_log->id;

    # Write first message
    $log_message = '~~~ Lancement du job ~~~';
    saveLogMessage($list_log_id, $log_message);

    # Return ID
    return $list_log_id;
}

/**
 * End a job's log
 *
 * @param $log_id
 * @return bool
 */
function endJob($log_id)
{
    $message = '~~~ END ~~~';
    saveLogMessage($log_id, $message);

    return true;
}

/**
 * Save a new message in the database
 *
 * @param $log_id
 * @param $log_message
 * @return bool
 */
function saveLogMessage($log_id, $log_message)
{
    # Initialize
    $log = new Log();

    # Fill fields
    $log->list_log_id = $log_id;
    $log->message = $log_message;

    # Save log
    $log->save();

    return true;
}