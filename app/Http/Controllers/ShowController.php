<?php

namespace App\Http\Controllers;

use App\Repositories\ShowRepository;


class ShowController extends Controller
{
    protected $showRepository;

    public function __construct(ShowRepository $showRepository)
    {
        $this->showRepository = $showRepository;
    }

    public function getShow($show_url)
    {
        $show = $this->showRepository->getShowByURL($show_url);

        return view('show/');
    }

}