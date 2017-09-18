<?php

/**
 * Get user's role and color
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