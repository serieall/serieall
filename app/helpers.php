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
function saveLogMessage($logID, $logMessage)
{
    $log = new Log();
    $log->list_log_id = $logID;
    $log->message = $logMessage;
    $log->save();

    return true;
}

/**
 * @param $id
 * @return string
 */
function roleUser($id) {
    switch ($id) {
        case 1:
            $role = "Administrateur";
            $color = "red";
            break;
        case 2:
            $role = "Rédacteur";
            $color = "purple";
            break;
        case 3:
            $role = "Membre VIP";
            $color = "orange";
            break;
        case 4:
            $role = "Membre";
            $color = "black";
            break;
        default:
            $role = "Inconnu";
            $color = "grey";
    }

    $text = "<span class=\"ui " . $color . " text\">" . $role . "</span>";

    return $text;

}

/**
 * @param $note
 * @return int
 */
function noteToCircle($note) {
    $noteMax = config('param.noteMax');
    $radiusCircle = config('param.radiusCircleNote');

    $dashArray = 2 * pi() * $radiusCircle;
//    565.48

    return $dashArray * (1 - $note / $noteMax);

}

/**
 * @param $resume
 * @return string
 */
function cutResume($resume) {
    $nombreCaracResume = config('param.nombreCaracResume');

    // On insère des marqueurs "***" dans le texte
    $text = wordwrap($resume, $nombreCaracResume, "***", true);

    $tcut = explode("***", $text);

    // La première partie du tableau est celle qui nous intéresse
    $part1 = $tcut[0];
    $part2 = '';

    for($i=1; $i<count($tcut); $i++) {
        $part2 .= $tcut[$i].' ';
    }

    // Suppression du dernier espace dans la partie de texte restante
    $part2 = trim($part2);

    // On retourne la partie 1 avec les points de suspension
    return $part1 . " ...";
}

/**
 * Convertion d'une array en string
 *
 * @param $objects
 * @return string
 * @internal param $objets
 */
function formatRequestInVariable($objects) {
    $list = '';

    // Pour chaque chaine on incrémente dans une variable
    foreach ($objects as $object){
        $list.= $object->name . ', ';
    }

    // On enlève la dernière virgule
    $list = substr($list, 0, -2);

    return $list;
}