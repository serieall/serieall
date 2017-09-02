<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Models\Episode;
use App\Models\Episode_user;
use App\Models\Season;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

class ShowController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * Envoi vers la page shows/index
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShow($show_url)
    {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        return view('shows/index', compact('showInfo'));
    }

    /**
     * Envoi vers la page shows/details
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowDetails($show_url) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        return view('shows/details', compact('showInfo'));
    }

    /**
     * Envoi vers la page shows/seasons
     *
     * @param $show_url
     * @param $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowSeasons($show_url, $season) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $season);

        return view('shows.seasons', compact('showInfo', 'seasonInfo'));
    }

    public function getShowEpisodes($showURL, $seasonName, $episodeNumero, $episodeID = null)
    {
        $showInfo = $this->showRepository->getInfoShowFiche($showURL);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $seasonName);

        if($episodeNumero == 0) {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonInfo->id, $episodeNumero, $episodeID);
        }
        else {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroAndSeasonID($seasonInfo->id, $episodeNumero);
        }

        $totalEpisodes = $seasonInfo->episodes_count - 1;

        return view('shows.episodes', compact('showInfo', 'seasonInfo', 'episodeInfo', 'totalEpisodes'));
    }

    /**
     * Notation d'un épisode
     *
     * @param RateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rateEpisode(RateRequest $request)
    {
        $user_id = $request->user()->id;
        $rate_ref = Episode_user::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->first();
        $episode_ref = $this->episodeRepository->getEpisodeByID($request->episode_id);
        $season_ref = $this->seasonRepository->getSeasonByID($episode_ref->season_id);
        $show_ref = $this->showRepository->getShowByID($season_ref->show_id);

        if(is_null($rate_ref)) {
            echo "n'existe pas";
            $episode_ref->users()->attach($user_id, ['rate' => $request->note]);


            # On incrémente tous les nombres d'épisodes
            $episode_ref->nbnotes += 1;
            $season_ref->nbnotes += 1 ;
            $show_ref->nbnotes += 1;
        }
        else {
            echo "existe";
            $episode_ref->users()->updateExistingPivot($user_id, ['rate' => $request->note]);
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

        return redirect()->back();
    }
}