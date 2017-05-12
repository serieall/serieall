<?php

namespace App\Http\Controllers;

use App\Repositories\ShowRepository;


class ShowController extends Controller
{
    protected $showRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     */
    public function __construct(ShowRepository $showRepository)
    {
        $this->showRepository = $showRepository;
    }

    /**
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShow($show_url)
    {
        $show = $this->showRepository->getShowByURL($show_url);

        return view('shows/fiche', compact('show'));
    }
}