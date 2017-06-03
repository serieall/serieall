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
        $genres = $this->showRepository->formatRequestInVariable($show->genres);
        $nationalities = $this->showRepository->formatRequestInVariable($show->nationalities);
        $channels = $this->showRepository->formatRequestInVariable($show->channels);

        $noteCircle = noteToCircle($show->moyenne);

        /** Détection du résumé à afficher (fr ou en)*/
        if(empty($show->synopsis_fr)) {
            $synopsis = $show->synopsis;
        }
        else {
            $synopsis = $show->synopsis_fr;
        }

        $nombreCaracResume = config('param.nombreCaracResume');
        if(strlen($synopsis) <= $nombreCaracResume) {
            $showSynopsis = $synopsis;
            $resumeComplet = false;
        }
        else {
            $showSynopsis = cutResume($synopsis);
            $resumeComplet = true;
        }

        return view('shows/fiche', compact('show', 'seasons', 'genres', 'nationalities', 'channels', 'noteCircle', 'showSynopsis', 'resumeComplet'));
    }

    public function getShowDetails($show_url) {
        $show = $this->showRepository->getShowDetailsByURL($show_url);
        $seasons = $this->seasonRepository->getSeasonsCountEpisodesForShowByID($show->id);
        $genres = $this->showRepository->formatRequestInVariable($show->genres);
        $nationalities = $this->showRepository->formatRequestInVariable($show->nationalities);
        $channels = $this->showRepository->formatRequestInVariable($show->channels);

        $noteCircle = noteToCircle($show->moyenne);

        /** Détection du résumé à afficher (fr ou en)*/
        if(empty($show->synopsis_fr)) {
            $synopsis = $show->synopsis;
        }
        else {
            $synopsis = $show->synopsis_fr;
        }

        $nombreCaracResume = config('param.nombreCaracResume');
        if(strlen($synopsis) <= $nombreCaracResume) {
            $showSynopsis = $synopsis;
            $resumeComplet = false;
        }
        else {
            $showSynopsis = cutResume($synopsis);
            $resumeComplet = true;
        }

        return view('shows/details', compact('show', 'seasons', 'genres', 'nationalities', 'channels', 'noteCircle', 'showSynopsis', 'resumeComplet'));
    }
}