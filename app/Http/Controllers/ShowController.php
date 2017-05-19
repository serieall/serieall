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
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShow($show_url)
    {
        $show = $this->showRepository->getShowByURL($show_url);
        $seasons = $this->seasonRepository->getSeasonsCountEpisodesForShowByID($show->id);

        return view('shows/fiche', compact('show', 'seasons'));
    }
}