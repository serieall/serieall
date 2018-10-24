<?php
declare(strict_types=1);

use App\Repositories\RateRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;

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

    return '<span class="ui ' . $color . ' text">' . $role . '</span>';
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

/**
 * @param RateRepository $rateRepository
 * @param $user_id
 * @return string
 */
function getTimePassedOnShow(RateRepository $rateRepository, $user_id) {
    $nb_minutes = 0;

    $rates = $rateRepository->getRatesAggregateByShowForUser($user_id, "sh.name");
    foreach($rates as $rate) {
        $nb_minutes = $nb_minutes + $rate->minutes;
    }
    Carbon::setLocale('fr');
    return CarbonInterval::fromString($nb_minutes . 'm')->cascade()->forHumans();

}