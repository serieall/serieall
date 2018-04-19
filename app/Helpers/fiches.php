<?php
declare(strict_types=1);

/**
 * Generate rate on its circle
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
 * Get Actor's picture
 *
 * @param $actor
 * @return string
 */
function ActorPicture($actor){
    $folderActors = config('directories.actors');

    if(file_exists(public_path() . "$folderActors" . "$actor.jpg")) {
        return $folderActors . $actor . '.jpg';
    } else {
        return $folderActors . 'default_empty.jpg';
    }
}

/**
 * Get Show's picture
 *
 * @param $show
 * @return string
 */
function ShowPicture($show){
    $folderShows = config('directories.shows');

    if(file_exists(public_path() . "$folderShows" . "$show.jpg")) {
        return $folderShows . $show . '.jpg';
    } else {
        return $folderShows . 'default_empty.jpg';
    }
}

/**
 * Get number of episode with or without link
 *
 * @param $show_url
 * @param $season_number
 * @param $episode_number
 * @param $episode_id
 * @param $link_enabled
 * @param $episode_string
 * @return string
 */
function affichageNumeroEpisode($show_url, $season_number, $episode_number, $episode_id, $link_enabled, $episode_string) {
    if( $episode_string ) {
        if($episode_number == 0){
            $text = 'Episode spécial';
        }
        else {
            $text = 'Episode ' . $season_number . '.' . sprintf('%02s', $episode_number);
        }
    }
    else {
        $text = $season_number . '.' . sprintf('%02s', $episode_number);
    }

    if($link_enabled) {
        if ($episode_number == 0) {
            return '<a href="' . route('episode.fiche', [$show_url, $season_number, $episode_number, $episode_id]) . '">' . $text . '</a>';
        } else {
            return '<a href="' . route('episode.fiche', [$show_url, $season_number, $episode_number]) . '">' . $text . '</a>';
        }
    }
    else {
        return $text;
    }
}

/**
 * Print rate with color
 *
 * @param $rate
 * @return string
 */
function affichageNote($rate) {
    $noteGood = config('param.good');
    $noteNeutral = config('param.neutral');

    if($rate >= $noteGood) {
        return "<span class=\"ui green text\">$rate</span>";
    }
    elseif($rate >= $noteNeutral && $rate < $noteGood) {
        return "<span class=\"ui gray text\">$rate</span>";
    }
    elseif($rate < 1) {
        return "<span class=\"ui gray text\">-</span>";
    }
    else {
        return "<span class=\"ui red text\">$rate</span>";
    }
}

/**
 * Print the comment type
 *
 * @param $thumb
 * @return string
 */
function affichageThumb($thumb) {
    switch ($thumb) {
        case 1:
            return '<td class="ui green text AvisStatus">Avis favorable</td>';
            break;
        case 2:
            return '<td class="ui grey text AvisStatus">Avis neutre</td>';
            break;
        case 3:
            return '<td class="ui red text AvisStatus">Avis défavorable</td>';
            break;
        default:
            return false;
            break;
    }
}

/**
 * @param $thumb
 * @return string
 */
function affichageThumbBorder($thumb) {
    switch ($thumb) {
        case 1:
            return 'lb-green';
            break;
        case 2:
            return 'lb-grey';
            break;
        case 3:
            return 'lb-red';
            break;
        default:
            return false;
            break;
    }
}

/**
 * Generate a message if user comment exist
 *
 * @param $object
 * @param $user_comment
 * @return string
 */
function messageComment($object, $user_comment = null) {
    switch($object){
        case 'Show':
            $text = 'cette série';
            break;
        case 'Season':
            $text = 'cette saison';
            break;
        case 'Episode':
            $text = 'cet épisode';
            break;
        default:
            $text = 'cet objet';
            break;
    }

    if(is_null($user_comment)) {
        return "Aucun membre n'a donné son avis sur " . $text . '. Ecrivez un avis pour être le premier !';
    }
    else {
        return 'Vous êtes le seul à avoir donné votre avis sur ' . $text . '.';
    }
}

/**
 * Compile all objects informations
 *
 * @param $object
 * @param $object_id
 * @return array
 */
function compileObjectInfos($object, $object_id) {
    $object = [
        'id' => $object_id,
        'model' => $object,
        'fq_model' => 'App\Models\\' . $object
    ];

    return $object;
}

/**
 * Print the name of the episode, with or without link/number
 *
 * @param $episode
 * @param $hasNumber
 * @param $hasLink
 * @return mixed
 */
function afficheEpisodeName($episode, $hasNumber, $hasLink)
{
    // Choose the field we use for the name
    if (empty($episode->name_fr)) {
        $name = $episode->name;
    } else {
        $name = $episode->name_fr;
    }

    // If we want the number
    if ($hasNumber) {
        if ($episode->numero == 0) {
            $text = 'Episode spécial';
        } else {
            $text = 'Episode ' . $episode->season->name . '.' . sprintf('%02s', $episode->numero);
        }
        $text = $text . ' - ' . $name;
    } else {
        $text = $name;
    }

    // If we want the link
    if ($hasLink) {
        $text = '<a href="' . route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) . '">' . $text . '</a>';
    }

    return $text;
}

/**
 * Affichage du nombre de commentaires
 *
 * @param $thumb
 * @return string
 */
function affichageCountThumb($thumb){
    if($thumb === null) {
        return '0';
    }

    return $thumb->count_thumb;
}

/**
 * Return the color of the category
 *
 * @param $id
 * @return string
 */
function colorCategory($id) {
    switch($id){
        case 1:
            $color = 'green';
            break;
        case 2:
            $color = 'olive';
            break;
        case 3:
            $color = 'red';
            break;
        case 4:
            $color = 'yellow';
            break;
        case 5:
            $color = 'pink';
            break;
        case 6:
            $color = 'purple';
            break;
        case 7:
            $color = 'blueSA';
            break;
        default:
            $color = 'blueSA';
            break;
    }

    return $color;
}