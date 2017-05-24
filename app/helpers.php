<?php

use App\Models\Log;

/**
 * @param $logID
 * @param $logMessage
 * @return bool
 * @internal param $logJob
 * @internal param $logObjet
 * @internal param $logName
 */
function saveLogMessage($logID, $logMessage){
    $log = new Log();
    $log->list_log_id = $logID;
    $log->message = $logMessage;
    $log->save();

    return true;
}

function noteToCircle($note) {
    $noteMax = config('param.noteMax');
    $radiusCircle = config('param.radiusCircleNote');

    $dashArray = 2 * pi() * $radiusCircle;
//    565.48

    return $dashArray * (1 - $note / $noteMax);

}

function cutResume($resume) {
    $nombreMotResume = config('param.nombreMotResume');

    $text = wordwrap($resume, $nombreMotResume, "***", true); // insertion de marqueurs ***

    $tcut = explode("***", $text); // on créé un tableau à partir des marqueurs ***
    $part1 = $tcut[0]; // la partie à mettre en exergue
    $part2 = '';
    for($i=1; $i<count($tcut); $i++) {
        $part2 .= $tcut[$i].' ';
    }
    $part2 = trim($part2); //suppression du dernier espace dans la partie de texte restante

    return $part1 . " ...";
}
