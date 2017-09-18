<?php

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
        return $folderActors . $actor . ".jpg";
    } else {
        return $folderActors . "default_empty.jpg";
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
        $text = "Episode " . $season_number . "." . sprintf("%02s", $episode_number);
    }
    else {
        $text = $season_number . "." . sprintf("%02s", $episode_number);
    }

    if($link_enabled) {
        if ($episode_number == 0) {
            return "<a href=\"" . route('show.episodes', [$show_url, $season_number, $episode_number, $episode_id]) . "\">" . $text . "</a>";
        } else {
            return "<a href=\"" . route('show.episodes', [$show_url, $season_number, $episode_number]) . "\">" . $text . "</a>";
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

    if($rate > $noteGood) {
        return "<span class=\"ui green text\">$rate</span>";
    }
    elseif($rate > $noteNeutral && $rate < $noteGood) {
        return "<span class=\"ui gray text\">$rate</span>";
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
            return "<td class=\"ui green text AvisStatus\">Avis favorable</td>";
            break;
        case 2:
            return "<td class=\"ui grey text AvisStatus\">Avis neutre</td>";
            break;
        case 3:
            return "<td class=\"ui red text AvisStatus\">Avis défavorable</td>";
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
            return "green";
            break;
        case 2:
            return "grey";
            break;
        case 3:
            return "red";
            break;
        default:
            return false;
            break;
    }
}