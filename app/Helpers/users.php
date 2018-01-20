<?php
declare(strict_types=1);

/**
 * Get user's role and color
 *
 * @param $id
 * @return string
 */
function roleUser($id) {
    switch ($id) {
        case 1:
            $role = 'Administrateur';
            $color = 'red';
            break;
        case 2:
            $role = 'Rédacteur';
            $color = 'purple';
            break;
        case 3:
            $role = 'Membre VIP';
            $color = 'orange';
            break;
        case 4:
            $role = 'Membre';
            $color = 'black';
            break;
        default:
            $role = 'Inconnu';
            $color = 'grey';
    }

    $text = '<span class="ui ' . $color . ' text">' . $role . '</span>';

    return $text;
}

/**
 * @return int|null
 */
function getIDIfAuth() {
    # Define variables
    if(Auth::check()) {
        $user_id = Auth::user()->id;
    }
    else {
        $user_id = null;
    }

    return $user_id;
}