<?php

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

    // On vérifie si il y a une balise spoiler dans le texte
    if(strstr($part1, "<div class=\"spoiler\">")) {

        // On vérifie qu'elle est fermée
        if(strstr($part1, "</div></div>")) {
            return $part1 . " ...";
        }
        else {
            return "Le résumé de cet avis contient des spoilers, cliquez sur \"Lire l'avis complet\" pour le consulter.";
        }
    }
    else {
        return $part1 . " ...";
    }
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
 * Génére un format de date
 *
 * @param $lenght
 * @param $date
 * @return false|string
 */
function formatDate($lenght, $date) {
    setlocale(LC_TIME, 'french');

    switch ($lenght){
        case 'short':
            $format = '%d %h %Y';
            break;
        case 'long':
            $format = '%d %B %Y';
            break;
        case 'full':
            $format = '%d %B %Y &agrave; %H:%M';
            break;
        default:
            $format = '%d %M %Y';
            break;
    }

    $date_format = strftime($format, strtotime($date));

   return utf8_encode($date_format);
}

