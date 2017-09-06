<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Models\Episode;
use App\Models\Episode_user;
use App\Models\Season;
use App\Models\User;
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

//        $ratesSeason = Season::with(['episodes',
//            'episodes.users' => function ($query) {
//            $query->select('username','rate' ,'episode_user.updated_at');
//            $query->orderBy('episode_user.updated_at', 'desc');
//        }])
//            ->where('seasons.id', '=', $seasonInfo->id)
//            ->first();
//
//        $ratesSeason = User::select('id','username')
//            ->with(['episodes' => function($q){
//                $q->select('id', 'numero', 'rate', 'episode_user.updated_at');
//            }
//                ,'episodes.season' => function($query) use ($seasonInfo){
//                $query->where('id', '=', $seasonInfo->id);
//            }])
//            ->get()
//            ->toArray();
//
        $ratesSeason = Season::select('id','name')
            ->with(['users'])
            ->where('id', '=', $seasonInfo->id)
            ->first()
            ->toArray();

        dd($ratesSeason);
        return view('shows.seasons', compact('showInfo', 'seasonInfo', 'rates'));
    }

    /**
     * Envoi vers la page shows/episodes
     *
     * @param $showURL
     * @param $seasonName
     * @param $episodeNumero
     * @param null $episodeID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        $rates = $this->episodeRepository->getRatesByEpisodeID($episodeInfo->id);

        return view('shows.episodes', compact('showInfo', 'seasonInfo', 'episodeInfo', 'totalEpisodes', 'rates'));
    }
}