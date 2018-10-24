<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Episode_user;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Show;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class RateRepository
 * @package App\Repositories
 */
class RateRepository
{
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;

    /**
     * RateRepository constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository) {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * Rate an episode
     *
     * @param $user_id
     * @param $episode_id
     * @param $rate
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function RateEpisode($user_id, $episode_id, $rate) {
        // La note existe-elle ?
        $rate_ref = Episode_user::where('episode_id', '=', $episode_id)
            ->where('user_id', '=', $user_id)
            ->first();

        // Objets épisode, saison et séries
        $episode_ref = $this->episodeRepository->getEpisodeByID($episode_id);
        $season_ref = $this->seasonRepository->getSeasonByID($episode_ref->season_id);
        $show_ref = $this->showRepository->getShowByID($season_ref->show_id);

        // Si la note n'exite pas
        if(is_null($rate_ref)) {
            // On l'ajoute
            $episode_ref->users()->attach($user_id, ['rate' => $rate]);

            # On incrémente tous les nombres d'épisodes
            ++$episode_ref->nbnotes;
            ++$season_ref->nbnotes;
            ++$show_ref->nbnotes;
        }
        else {
            // On la met simplement à jour
            $episode_ref->users()->updateExistingPivot($user_id, ['rate' => $rate]);
        }

        // On calcule sa moyenne et on la sauvegarde dans l'objet
        $mean_episode = Episode_user::where('episode_id', '=', $episode_ref->id)
            ->avg('rate');
        $episode_ref->moyenne = $mean_episode;
        $episode_ref->save();

        // On calcule la moyenne de la saison et on la sauvegarde dans l'objet
        $mean_season = Episode::where('season_id', '=', $season_ref->id)
            ->where('moyenne', '>', 0)
            ->avg('moyenne');

        $season_ref->moyenne = $mean_season;
        $season_ref->save();

        // On calcule la moyenne de la série et on la sauvegarde dans l'objet
        $mean_show = Season::where('show_id', '=', $show_ref->id)
            ->where('moyenne', '>', 0)
            ->avg('moyenne');

        $show_ref->moyenne = $mean_show;
        $show_ref->save();

        return true;
    }

    /**
     * Get Rate of an episode by a user
     *
     * @param $user_id
     * @param $episode_id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getRateByUserIDEpisodeID($user_id, $episode_id) {
        return Episode_user::whereEpisodeId($episode_id)
            ->whereUserId($user_id)
            ->pluck('rate')
            ->first();
    }

    /**
     * Get Last 20 Rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLast20Rates() {
        return Episode_user::with(['user', 'episode' => function($q){
            $q->with('season');
            $q->with('show');
        }])->limit(20)
            ->get();
    }

    /**
     * Get lasts rates of a user
     *
     * @param $user_id
     * @param $episode_id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getRateByUserID($user_id) {
        return Episode_user::with(['user', 'episode' => function($q) {
            $q->with('season');
            $q->with('show');
        }])
            ->whereUserId($user_id)
            ->limit(5)
            ->get();
    }

    /**
     * Get all rates of a user
     *
     * @param $user_id
     * @param $episode_id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getAllRateByUserID($user_id) {
        return Episode_user::whereUserId($user_id);
    }

    /**
     * Get rates aggregate by show for a particular user
     *
     * @param $user_id
     * @param $order
     * @return array
     */
    public function getRatesAggregateByShowForUser($user_id, $order) {
        $sql = "select sh.name, sh.show_url, sh.format, sh.format * COUNT(eu.rate) AS minutes, COUNT(eu.rate) nb_rate, TRIM(ROUND(AVG(eu.rate),2))+0 avg_rate, u.username
            FROM shows sh, seasons s, episodes e, users u, episode_user eu
            WHERE sh.id = s.show_id
            AND s.id = e.season_id
            AND eu.episode_id = e.id
            AND eu.user_id = u.id
            AND u.id = '$user_id'
            GROUP BY sh.name,sh.show_url, u.username
            ORDER BY $order";

        return DB::select(DB::raw($sql));
    }
}