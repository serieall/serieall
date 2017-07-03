<?php

use App\Models\Log;

use App\Models\List_log;

/**
 * Initialisation du job d'ajout
 *
 * @param $idUser
 * @param $type
 * @param $model
 * @param $idModel
 * @return int
 */
function initJob($idUser, $type, $model, $idModel)
{
    # Définition du nom du job
    $list_log = new List_log();
    $list_log->job = $type;
    $list_log->object = $model;
    $list_log->object_id = $idModel;
    $list_log->user_id = $idUser;

    $list_log->save();

    $listLogID = $list_log->id;

    $logMessage = '~~~ Lancement du job ~~~';
    saveLogMessage($listLogID, $logMessage);

    return $listLogID;
}

/**
 * Enregistrement d'un nouveau message de log dans la base de données
 *
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

function endJob($logID)
{
    $message = '~~~ END ~~~';
    saveLogMessage($logID, $message);

    return true;
}

/**
 * Génération du rôle d'un utilisateur avec la couleur associée
 *
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
 * Génération de la note sur son cercle dans la fiche série
 *
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
 * Découpage du résumé
 *
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

/**
 * Convertion d'une array en string sans espace
 *
 * @param $objects
 * @return string
 * @internal param $objets
 */
function formatRequestInVariableNoSpace($objects) {
    $list = '';

    // Pour chaque chaine on incrémente dans une variable
    foreach ($objects as $object){
        $list.= $object->name . ',';
    }

    // On enlève la dernière virgule
    $list = substr($list, 0, -1);

    return $list;
}

/**
 * Renvoi l'image d'un acteur
 *
 * @param $actor
 * @return string
 */
function ActorPicture($actor){
    $folderActors = config('directories.actors');

    if(file_exists(public_path() . "$folderActors" . "$actor.jpg")) {
        return $folderActors . $actor . ".jpg";
    } else {
        return $folderActors . "default_empty.jpg";
    }
}