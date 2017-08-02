<?php

namespace App\Http\Controllers;

use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;

class ShowController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
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
}