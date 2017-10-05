<?php


namespace App\Repositories;

use App\Models\Episode_user;
use App\Models\Episode;
use App\Models\Season;

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
            $episode_ref->nbnotes += 1;
            $season_ref->nbnotes += 1;
            $show_ref->nbnotes += 1;
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

}